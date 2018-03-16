<?php

namespace App\Apptj\Controllers;


use App\Apptj\Core\CustomController;
use SKYCore\Modules\LanguageReplacer;

class Financial extends CustomController
{
    public function __construct()
    {
        parent::__construct();

        new_system_callback('application_langreplace',[$this,'loadLang']);
    }

    public function graphs()
    {

        $js = [
            'js' => [
                [
                    'extern' => '',
                    'src' => 'https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.min.js'
                ]
            ]
        ];

        $data = [
            'header' => [
                'title' => '{{ locale.financial.page_title.index }} - {{ locale.financial.general.financial }} - {{ locale.session_data.company_name }}'
            ]
        ];

        $data['footer'] = array_merge($data['footer'] ?? [],loadAssets($js));

        loadView('index.php',$data);
    }
    
    public function transaction()
    {

        $js = [
            'js' => [
                [
                    'extern' => '',
                    'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js'
                ],
                [
                    'extern' => '',
                    'src' => '//cdn.jsdelivr.net/momentjs/latest/moment.min.js'
                ],
                [
                    'extern' => '',
                    'src' => 'https://cdn.rawgit.com/moment/moment/develop/locale/pt-br.js'
                ],
                [
                    'extern' => '',
                    'src' => 'https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/5a991bff/src/js/bootstrap-datetimepicker.js'
                ]
            ]
        ];

        $css = [
            'css' => [
                [
                    'extern' => '',
                    'href' => 'https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/5a991bff/build/css/bootstrap-datetimepicker.min.css'
                ],
            ],
        ];

        $data = [
            'header' => [
                'title' => '{{ locale.financial.page_title.transaction }} - {{ locale.financial.general.financial }} - {{ locale.session_data.company_name }}',
            ]
        ];

        $data['footer'] = array_merge($data['footer'] ?? [],loadAssets($js));
        $data['header'] = array_merge($data['header'] ?? [],loadAssets($css));

        loadView('transaction.php',$data);
    }

    public function conversion()
    {
        $assets = [
            'js' => [
                [
                    'extern' => '',
                    'src' => 'https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js'
                ]
            ]
        ];

        $data = [
            'header' => [
                'title' => '{{ locale.financial.page_title.conversion }} - {{ locale.financial.general.financial }} - {{ locale.session_data.company_name }}',
            ]
        ];

        $data['header'] = array_merge($data['header'],loadAssets($assets));

        loadView('conversion.php',$data);
    }
    
    public function recurrence()
    {
        $data = [
            'header' => [
                'title' => '{{ locale.financial.page_title.history }} - {{ locale.financial.general.financial }} - {{ locale.session_data.company_name }}'
            ]
        ];

        $css = [
            'css' => [
                [
                    'extern' => '',
                    'href' => 'https://cdn.datatables.net/v/bs/jszip-3.1.3/pdfmake-0.1.27/dt-1.10.15/b-1.4.0/b-html5-1.4.0/b-print-1.4.0/fh-3.1.2/kt-2.3.0/r-2.1.1/se-1.2.2/datatables.min.css'
                ]
            ]
        ];

        $js = [
            'js' => [
                [
                    'extern' => '',
                    'src' => 'https://cdn.datatables.net/v/bs/jszip-3.1.3/pdfmake-0.1.27/dt-1.10.15/b-1.4.0/b-html5-1.4.0/b-print-1.4.0/fh-3.1.2/kt-2.3.0/r-2.1.1/se-1.2.2/datatables.min.js'
                ]
            ]
        ];

        $data['header'] = array_merge($data['header'],loadAssets($css));
        $data['footer'] = array_merge($data['footer'] ?? [],loadAssets($js));

        loadView('recurrence.php',$data);
    }

    public function history()
    {
        $data = [
            'header' => [
                'title' => '{{ locale.financial.page_title.history }} - {{ locale.financial.general.financial }} - {{ locale.session_data.company_name }}'
            ]
        ];

        $css = [
            'css' => [
                [
                    'extern' => '',
                    'href' => 'https://cdn.datatables.net/v/bs/jszip-3.1.3/pdfmake-0.1.27/dt-1.10.15/b-1.4.0/b-html5-1.4.0/b-print-1.4.0/fh-3.1.2/kt-2.3.0/r-2.1.1/se-1.2.2/datatables.min.css'
                ]
            ]
        ];

        $js = [
            'js' => [
                [
                    'extern' => '',
                    'src' => 'https://cdn.datatables.net/v/bs/jszip-3.1.3/pdfmake-0.1.27/dt-1.10.15/b-1.4.0/b-html5-1.4.0/b-print-1.4.0/fh-3.1.2/kt-2.3.0/r-2.1.1/se-1.2.2/datatables.min.js'
                ]
            ]
        ];

        $data['header'] = array_merge($data['header'],loadAssets($css));
        $data['footer'] = array_merge($data['footer'] ?? [],loadAssets($js));

        loadView('history.php',$data);
    }

    function loadLang(LanguageReplacer $lr){
        $customLR = LanguageReplacer::langReplaceByControllerWF();
        $lr->models = array_merge($customLR->models,$lr->models);
        $lr->texts = array_merge($customLR->texts,$lr->texts);

        return $lr;
    }
}