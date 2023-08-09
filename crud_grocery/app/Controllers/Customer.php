<?php

namespace App\Controllers;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use App\Controllers\BaseController;
use App\Libraries\GroceryCrud;
use CodeIgniter\Language\Language;
use App\Models\ExportExcelModel;
use Config\Services;
//use CodeIgniter\Database\ConnectionInterface;

$validation = \Config\Services::validation();

class Customer extends BaseController
{
    protected $db;
    public function __construct()
    {
        $db = db_connect();

        //$this->db = &$db;
    }
    public function change($lang)
    {
        $session = session();
        if ($lang == '1') {
            $session->set('lang', 'english');  
        }
        else if($lang == '2')
        {
            $session->set('lang', 'Chinese');
        }
        else
        {
           $session->set('lang', 'Malay');
        }
        return redirect()->to('customer'); 
        // $language = $this->request->getPost('language');

        // if (in_array($language, config('App')->supportedLocales)) {
        //     Services::language()->setLocale($language);
        // }

        // return redirect()->back();
    }

    
    public function userdata()
    {
        // $language = new Language();
        // $language->load('grocery_crud', 'en');
        $db = \Config\Database::connect();
        $validation = \Config\Services::validation();
        $crud = new GroceryCrud();
        // $session = \Config\Services::session($config);
        $session = session();
       
        $crud->setTable('user');
        $crud->setClone();
        $crud->setRead();
        //$crud->setLanguagePath('application/language/grocery-crud/Spanish.php');
        // if($session->get('lang')=='Malay')
        // {
        //     $crud->columns(['email', 'mobile'])
        //     ->displayAs([
        //         'email' => lang('Mycustom.email'),
        //         'mobile' => lang('Mycustom.mobile'),
        //     ]);
        // }
        // else
        // {
            if($session->get('lang')){
                $crud->setLanguage($session->get('lang'));
            }
            
           // $crud->setLanguagePath('application/language/grocery-crud/');
            $crud->columns(['email', 'mobile'])
            ->displayAs([
                'email' => 'User Email',
                'mobile' => 'User Image'
            ]);

        //}
       
        $crud->addFields(['email', 'mobile', 'new_img']);
        
        $crud->callbackColumn('mobile', array($this, 'showImage'));
        
        //  $crud->setColumn('name', lang('name')); // Use the translated version of the column label
        // $crud->setColumn('description', lang('description'));

        // $crud->callbackEditField('mobile',array($this, '_callback_webpage_url'));
        // $crud->callbackColumn('mobile', function ($value, $row) {
        //     return "<img src='". WRITEPATH."assets/uploads/". $value . "' width=100>";
        // });

        $crud->setRule('email', 'Email', 'required|valid_email');
        //   $crud->setRule('mobile', 'Mobile', 'required|regex_match[/^[0-9]{10}$/]');
        $crud->callbackAddField(
            'mobile',
            function () {
                return '<input id="field-order_docs" type="file" class="form-control" name="mobile" value="">';
            }
        );
        //  $crud->callbackEditField('old_img', array($this, 'callback_test1'));
        $crud->callbackEditField('mobile', function ($fieldValue, $primaryKeyValue) {
            //     $rowData =  $this->db->table('user')
            //         ->where(["id" => $primaryKeyValue])
            //         ->get()
            //         ->getRow();
            //     //$rowData = $this->db->where('id', $primaryKeyValue)->get('user')->row();

            //     $mobile_data = $rowData->mobile;
            //   //  return '+30 <input name="telephone_number" value="' . $fieldValue . '"  />';

            //  return '<input id="field-order_docs" type="file" class="form-control" name="mobile">';
            return '<input type="hidden" name="mobile" value="' . $fieldValue . '">';
        });

        if ($crud->getState() == 'edit') {
            $crud->fieldType('mobile', 'hidden');
        }
        if ($crud->getState() == 'add') {
            $crud->fieldType('new_img', 'hidden');
        }

        $crud->callbackEditField('new_img', function ($fieldValue, $primaryKeyValue) {
            //     $rowData =  $this->db->table('user')
            //         ->where(["id" => $primaryKeyValue])
            //         ->get()
            //         ->getRow();
            //     //$rowData = $this->db->where('id', $primaryKeyValue)->get('user')->row();

            //     $mobile_data = $rowData->mobile;
            //   //  return '+30 <input name="telephone_number" value="' . $fieldValue . '"  />';

            return '<input id="field-order_docs" type="file" class="form-control" value="test" name="new_img">';
            //return '<input type="text" name="mobile" value="' . $fieldValue . '">';
        });

        $crud->callbackBeforeUpdate(array($this, 'callback_before_insert_or_update_test1'));
        $crud->callbackBeforeInsert(
            
            function ($cbData) {
                $toUpload = $this->request->getFile('mobile');
                $toUpload->move('assets/uploads');
                $cbData->data['mobile'] = $toUpload->getName();
                unset($cbData->data['new_img']);
                return $cbData;
            }
        );

        // $crud->callbackBeforeUpdate(
        //     function ($cbData) {
        //         $toUpload = $this->request->getFile('mobile');
        //         $toUpload->move('assets/uploads');
        //         $cbData->data['mobile'] = $toUpload->getName();
        //         return $cbData;
        //     }
        // );

        // $crud->setTheme('bootstrap');

        $crud->setTheme('bootstrap-v5');

        $output = $crud->render();

        $data['first'] =  lang('Mycustom.first');
        $data['second'] =  lang('Mycustom.second');
        $data['third'] =  lang('Mycustom.third');
        $data['output'] = $output;
        return view('example', (array)$output);
        //return $this->_exampleOutput($output);
    }


    function callback_before_insert_or_update_test1($post_array, $primary_key = null)
    {
        //unset($post_array['test1'], $post_array['test2'], $post_array['test3']);
        //  echo $this->request->getFile('new_img');
        if (!empty($_FILES['new_img']['name'])) {
            $toUpload = $this->request->getFile('new_img');
            $toUpload->move('assets/uploads');
            $post_array->data['mobile'] = $toUpload->getName();
            unset($post_array->data['new_img']);
            return $post_array;
        } else {
            unset($post_array->data['new_img']);
            return $post_array;
            //$this->db->insert(....);
        }

        //return $post_array;
    }

    function showImage($value)
    {
        return "<img src='" . base_url() . "assets/uploads/" . $value . "' width=70  height=70>";
    }

    public function user()
    {
        $crud = new GroceryCrud();

        $crud->setTable('user');
        $crud->setSubject('Customer');

        // Yep, is that easy!
        $crud->setTheme('bootstrap-v5');

        $output = $crud->render();
        return view('example', (array)$output);
    }

    public function export()
    {
        $model = new ExportExcelModel();
        $spreadsheet = new Spreadsheet();
        $data =  $model->selectQuery();

        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Id');
        $sheet->setCellValue('B1', 'First Name');
        $sheet->setCellValue('C1', 'Email');
        $sheet->setCellValue('D1', 'Mobile');
        $sheet->setCellValue('E1', 'Create At');

        $count = 2;

        foreach ($data as $row) {
            $sheet->setCellValue("A" . $count, $row->id);
            // $sheet->getColumnDimension('A'.$count)->setAutoSize(true);
            //$sheet->getActiveSheet()->getColumnDimension("A" . $count)->setAutoSize(TRUE);
            $sheet->setCellValue("B" . $count, $row->fname);
            // $sheet->getColumnDimension('B' . $count)->setAutoSize(true);
            $sheet->setCellValue("C" . $count, $row->email);
            // $sheet->getColumnDimension('C' . $count)->setAutoSize(true);
            $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
            $drawing->setName('Paid');
            $drawing->setDescription('Paid');
            $drawing->setPath('assets/uploads/' . $row->mobile); /* put your path and image here */
            $drawing->setCoordinates('D' . $count);
            $drawing->setHeight(40);
            $drawing->setWidth(40);
            $drawing->getShadow()->setVisible(true);
            $drawing->setWorksheet($spreadsheet->getActiveSheet());
            $spreadsheet->getActiveSheet()->getDefaultColumnDimension()->setWidth(40);
            $spreadsheet->getActiveSheet()->getRowDimension($count)->setRowHeight(40);
            // $spreadsheet->getActiveSheet()->getRowDimension('D'.$count)
            // ->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            //  $sheet->getStyle('D:E')->getAlignment()->setHorizontal('center');
            //  $sheet->getColumnDimension('D'.$count)->setAutoSize(false);

            $sheet->getStyle('D' . $count)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            // $spreadsheet->getActiveSheet()->getStyle('D'.$count)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
            // $spreadsheet->getActiveSheet()->getStyle('D'.$count)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);
            // $sheet->setCellValue("D".$count, $row->mobile);
            // $sheet->getColumnDimension('D' . $count)->setAutoSize(true);
            $sheet->setCellValue("E" . $count, $row->date_created);
            // $sheet->getColumnDimension('E' . $count)->setAutoSize(true);
            $count++;
        }

        foreach ($sheet->getColumnIterator() as $column) {
            $sheet->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('User-data.xlsx');
        return  $this->response->download("User-data.xlsx", null)->setFileName("UserList.xlsx");
    }

   

    public function language()
    {

       // echo lang('Mycustom.third');
     
        $session = session();
        $locale = $this->request->getLocale();
        $session->remove('lang');
        $session->set('lang', $locale);
        $url = base_url();
        
        $data['first'] =  lang('Mycustom.first');
        $data['second'] =  lang('Mycustom.second');
        $data['third'] =  lang('Mycustom.third');
        // $locale = $this->request->getLocale();
        return view('language', $data);


        // $data['first'] =  lang('Mycustom.first');
        // $data['second'] =  lang('Mycustom.second');
        // $data['third'] =  lang('Mycustom.third');

    }
}
