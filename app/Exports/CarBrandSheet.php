<?php

namespace App\Exports;

use App\Models\CarBrands;
use App\Models\CarBrandsChild;
use App\Models\work_lv4_project;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\FromCollection;

class CarBrandSheet implements FromCollection, WithTitle, WithEvents
{
    private $carBrand;
    private $rowCount;
    
    public function __construct($carBrand)
    {
        $this->carBrand = $carBrand;
    }
    
    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 25,
            'C' => 40,
            'D' => 15,
            'E' => 15,
            'F' => 15,
            'G' => 15,
            'H' => 25,
        ];
    }
    public function collection(){
        $data = new Collection();
        $data->push([
            'BÁO CÁO CÔNG VIỆC BỊ TRỄ',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
        ]);
    // Thêm tiêu đề
    $data->push([
        'TT',
        'Dự án',
        'Nội dung công việc',
        'Trách nhiệm',
        'Bắt đầu',
        'Kết thúc',
        'Tiến độ',
        'Ghi chú',
    ]);

       // Lấy tất cả car_brands_child thuộc carBrand hiện tại
       $carBrandChildren = CarBrandsChild::where('car_brands_id', $this->carBrand->id)->get();
      // Thêm dữ liệu vào sheet
      $romanIndex = 1;
      foreach ($carBrandChildren as $carBrandChild) {
          // Lấy tất cả công việc bị trễ theo carBrandChild
          $delayedWorks = $this->getDelayedWorks($carBrandChild);

          // Thêm tên carBrandChild vào sheet
          $data->push([
              $this->intToRoman($romanIndex) . '. ' . $carBrandChild->name,
              '',
              '',
          ]);

        if (count($delayedWorks) > 0) {
                $taskIndex = 0;
                $previousProjectName = null;
                foreach ($delayedWorks as $delayedWork) {
                    $projectDepartment = $delayedWork->workByProjectDepartment->projectDepartment;
                    $project = $projectDepartment->project;
                
                    if ($project->name_project !== $previousProjectName) {
                        $taskIndex++;
                        $previousProjectName = $project->name_project;
                    }
                
                    $data->push([
                        $taskIndex,
                        $project->name_project, // Dự án
                        $delayedWork->name_work, // Nội dung công việc
                        $delayedWork->responsibility, // Trách nhiệm
                        $delayedWork->startdate, // Bắt đầu
                        $delayedWork->enddate, // Kết thúc
                        $delayedWork->completion . '%', // Tiến độ (thêm % vào sau)
                        $delayedWork->note , // Ghi chú dựa trên trạng thái của công việc
                    ]);
                }

        } 

        $romanIndex++;
    }

    $this->rowCount = $data->count();
    return $data;
}
    

    private function intToRoman($number)
    {
        $romans = array(
            'M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1,
        );

        $result = '';

        foreach ($romans as $roman => $value) {
            $matches = intval($number / $value);
            $result .= str_repeat($roman, $matches);
            $number = $number % $value;
        }

        return $result;
    }

    private function getDelayedWorks($carBrandChild){
    $today = date('Y-m-d');

    $delayedWorks = work_lv4_project::whereHas('workByProjectDepartment', function ($query) use ($carBrandChild) {
        $query->whereHas('projectDepartment', function ($query2) use ($carBrandChild) {
            $query2->whereHas('project', function ($query3) use ($carBrandChild) {
                $query3->where('car_brands_child_id', $carBrandChild->id);
            });
        });
    })
    ->where('enddate', '<', $today)
    ->where('completion', '<', 100) // Thay đổi ở đây: chỉ lấy công việc chưa hoàn thành (completion < 100)
    ->get();

    return $delayedWorks;
    }

    public function title(): string
    {
        return $this->carBrand->name;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
                $drawing->setName('Logo');
                $drawing->setDescription('Logo');
                $drawing->setPath(public_path('assets/images/logo.png')); // Đường dẫn đến hình ảnh của bạn
                $drawing->setHeight(80); // Cao 80px
                $drawing->setCoordinates('A1'); // Đặt hình ảnh vào ô A1
                $drawing->setWorksheet($event->sheet->getDelegate());

                // Merge các ô mà bạn đã khoanh đỏ
                $event->sheet->getStyle('A3:A' . $event->sheet->getHighestRow())->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
                // Đặt chiều cao của hàng 1 bằng chiều cao của hình ảnh
                $event->sheet->getDelegate()->getRowDimension('1')->setRowHeight(57);
                
                // Đặt độ rộng của các cột
                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('F')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('G')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('H')->setAutoSize(true);

                // Định dạng tiêu đề chính "Công việc bị trễ"
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'size' => 18,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
    
                // Merge cells cho tiêu đề chính
                $event->sheet->mergeCells("A1:H1");
    
                // Định dạng màu nền cho hàng tiêu đề
                $event->sheet->getStyle('A2:H2')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'color' => [
                            'rgb' => '2EDDEA',
                        ],
                    ],
                ]);
    
                // Đóng khung tất cả các ô trong bảng
                $event->sheet->getStyle('A1:H' . $event->sheet->getHighestRow())->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '000000'],
                        ],
                    ],
                ]);
    
                // Định dạng in đậm và căn giữa cho các tiêu đề cột
                $event->sheet->getStyle('A2:H2')->applyFromArray([
                    'font' => [
                        'bold' => true,
                    ],
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                    ],
                ]);
    
                // Đặt độ rộng cột A (TT) để phù hợp
                $event->sheet->getColumnDimension('A')->setWidth(5);
    
                $rowNumber = 3;
                $rowCount = $this->rowCount;
                while ($rowNumber <= $rowCount) {
                    $cell = "A{$rowNumber}";
                    $value = $event->sheet->getCell($cell)->getValue();
                    $progressCell = "G{$rowNumber}";
                    $progressValue = $event->sheet->getCell($progressCell)->getValue();
                    if ($progressValue < 50) { // Replace 50 with the desired value
                        $event->sheet->getStyle($progressCell)->applyFromArray([
                            
                            'fill' => [
                                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                'color' => [
                                    'rgb' => 'FF0000',
                                ],
                            ],
                        ]);
                    }
                            
                    if (preg_match('/^[IVXLCDM]+\./', $value)) {
                        $event->sheet->getStyle($cell)->applyFromArray([
                            'font' => [
                                'bold' => true,
                            ],
                        ]);
                        $event->sheet->mergeCells("A{$rowNumber}:H{$rowNumber}");
        
                        // Căn chỉnh văn bản trái và giữa
                        $event->sheet->getStyle("A{$rowNumber}:H{$rowNumber}")->applyFromArray([
                            'alignment' => [
                                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                            ],
                        ]);
                    }else {
                        // Đưa dữ liệu "Tiến độ" và "Ghi chú" vào bảng
                        $event->sheet->setCellValue("G{$rowNumber}", $event->sheet->getCell("G{$rowNumber}")->getValue());
                        $event->sheet->setCellValue("H{$rowNumber}", $event->sheet->getCell("H{$rowNumber}")->getValue());
                    }
                    $rowNumber++;
                }
        
                // Merge cells for projectDepartment và căn chỉnh văn bản trái và giữa
                $mergeStart = 0;
                for ($i = 3; $i <= $rowCount + 1; $i++) {
                    $currentCell = "B{$i}";
                    $nextCell = "B" . ($i + 1);
                    
                    if ($event->sheet->getCell($currentCell)->getValue() === $event->sheet->getCell($nextCell)->getValue()) {
                        if ($mergeStart === 0) {
                            $mergeStart = $i;
                        }
                    } else {
                        if ($mergeStart !== 0) {
                            $event->sheet->mergeCells("B{$mergeStart}:B{$i}");
                            $event->sheet->getStyle("B{$mergeStart}:B{$i}")->applyFromArray([
                                'alignment' => [
                                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                                ],
                            ]);
                            $mergeStart = 0;
                        }
                    }
                }
                $mergeStart1 = 0;
                for ($i = 3; $i <= $rowCount + 1; $i++) {
                    $currentCell = "A{$i}";
                    $nextCell = "A" . ($i + 1);
                    
                    if ($event->sheet->getCell($currentCell)->getValue() === $event->sheet->getCell($nextCell)->getValue()) {
                        if ($mergeStart1 === 0) {
                            $mergeStart1 = $i;
                        }
                    } else {
                        if ($mergeStart1 !== 0) {
                            $event->sheet->mergeCells("A{$mergeStart1}:A{$i}");
                            $event->sheet->getStyle("A{$mergeStart1}:A{$i}")->applyFromArray([
                                'alignment' => [
                                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                                ],
                            ]);
                            $mergeStart1 = 0;
                        }
                    }
                }
               
                // Đóng khung toàn bộ dữ liệu
                $event->sheet->getStyle("A1:H{$rowCount}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
        
    }   
             
}