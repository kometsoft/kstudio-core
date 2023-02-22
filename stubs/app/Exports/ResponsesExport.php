<?php

namespace App\Exports;

use App\Helpers\StringUtil;
use App\Models\MyForm\Form;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

class ResponsesExport implements FromView, ShouldAutoSize, WithEvents
{
    protected $form;
    protected $column;

    public function __construct(Form $form)
    {
        $this->form   = $form;
        $this->column = 0;
    }

    public function view(): View
    {
        $this->form->load(['responses']);

        // Populate data
        $content = $this->form->content;
        $result  = $this->form->responses->mapWithKeys(function ($item) {
            return [
                $item->id => [
                    'id'         => $item->id,
                    'uuid'       => $item->uuid,
                    'form_id'    => $item->form_id,
                    'user_id'    => $item->user_id,
                    'user_agent' => $item->user_agent,
                    'content'    => $item->content,
                    'created_at' => $item->created_at,
                ],
            ];
        });

        // Locale
        $locale = $content['locale'] ?? 'default';

        // Map values
        if (count($content['pages'] ?? []) > 0) {
            foreach ($content['pages'] as $index_page => $page) {
                if (count($page['elements'] ?? []) > 0) {
                    foreach ($page['elements'] as $index_element => $element) {
                        if (isset($element['choices']) && is_array($element['choices'])) {
                            foreach ($element['choices'] as $choice) {
                                $content['pages'][$index_page]['elements'][$index_element]['values'][$choice['text'] ?? $choice['value'] ?? $choice] = $choice['text'] ?? $choice['value'] ?? $choice ?? '';
                            }
                        }
                    }
                }

                $this->column = $this->column + (count($page['elements'] ?? []));
            }
        }

        $data = [
            'form'    => $this->form,
            'locale'  => $locale,
            'content' => $content,
            'result'  => $result,
        ];

        return view('exports.response', $data);
    }

    public function registerEvents(): array
    {

        $style = [
            'font'    => [
                'bold'  => true,
                'color' => ['rgb' => '4338CA'],
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => Border::BORDER_MEDIUM,
                    'color'       => ['rgb' => '4338CA'],
                ],
            ],
            'fill'    => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['rgb' => 'E0E7FF'],
            ],
        ];

        return [
            AfterSheet::class => function (AfterSheet $event) use ($style) {
                $cell_range = 'A1:' . (StringUtil::num2alpha($this->column + 1)) . '1'; // All headers
                //$event->sheet->getDelegate()->getStyle($cell_range)->getFont()->setName('Calibri');
                $event->sheet->getDelegate()->getStyle($cell_range)->getFont()->setSize(12);
                $event->sheet->getStyle($cell_range)->applyFromArray($style);
                $event->sheet->setTitle(__('Responses'));
            },
        ];
    }
}
