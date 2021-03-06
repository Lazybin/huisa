<?php

namespace App\Http\Controllers\Admin;

use App\Model\BootPage;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class BootPageController extends Controller
{
    //
    public function show()
    {
        $data['bootPage']=BootPage::find(1)->toArray();
        return view('admin.setting.boot_page',$data);
    }

    public function store(Request $request)
    {


        if ($request->hasFile('input-id'))
        {
            $file = $request->file('input-id');
            $fileName=time().'.'.$file->getClientOriginalExtension();
            $file->move(base_path().'/public/upload',$fileName);

            $bootPage=BootPage::findOrNew(1);
            $bootPage->path='/upload/'.$fileName;
            $bootPage->save();
        }else{
            $bootPage=BootPage::findOrNew(1);
            $bootPage->path='';
            $bootPage->save();
        }
        return redirect()->action('Admin\BootPageController@show');
    }
}
