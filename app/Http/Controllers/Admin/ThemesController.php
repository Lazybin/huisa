<?php

namespace App\Http\Controllers\Admin;

use App\Model\Category;
use App\Model\Home;
use App\Model\SubjectThemes;
use App\Model\ThemeGoods;
use App\Model\Themes;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ThemesController extends Controller
{
    public function show()
    {
        $data['categories']=Category::where('pid',0)->get();
        return view('admin.themes.index',$data);
    }

    public function index(Request $request)
    {
        $start=$request->input('start', 0);
        $length=$request->input('length', 5);
        $draw=$request->input('draw', 1);


        $themes=Themes::skip($start)->take($length)->orderBy('id','desc');

        echo json_encode(array(
            "draw"            => intval( $draw ),
            "recordsTotal"    => intval(Themes::count()),
            "recordsFiltered" => intval(Themes::count()),
            "data"            => $themes->get()->toArray()
        ));
    }

    public function store(Request $request)
    {
        $params=$request->all();

        if ($request->hasFile('coverImage'))
        {
            $file = $request->file('coverImage');
            $fileName=md5(uniqid()).'.'.$file->getClientOriginalExtension();
            $file->move(base_path().'/public/upload',$fileName);


            $params['cover']='/upload/'.$fileName;
        }
        unset($params['coverImage']);

        if ($request->hasFile('headImage'))
        {
            $file = $request->file('headImage');
            $fileName=md5(uniqid()).'.'.$file->getClientOriginalExtension();
            $file->move(base_path().'/public/upload',$fileName);


            $params['head_image']='/upload/'.$fileName;
        }
        unset($params['headImage']);

        $params['category_id']=$params['category'];
        unset($params['category']);


        if($params['type']==1){
            $params['themes_description']=$params['description'];
            $params['description'];
        }

        $chooseGoods=$params['chooseGoods'];
        unset($params['chooseGoods']);

        $theme=Themes::create($params);

        $len=strlen($chooseGoods);
        if($len>0){
            $chooseGoods=substr($chooseGoods,0,$len-1);
            $chooseGoods=explode(',',$chooseGoods);
            foreach($chooseGoods as $i){
                $themeGoods=new ThemeGoods();
                $themeGoods->goods_id=$i;
                $themeGoods->theme_id=$theme->id;
                $themeGoods->save();
            }
        }


        return redirect()->action('Admin\ThemesController@show');
    }

    public function detail($id)
    {
        $goods=Themes::find($id);
        $ret['meta']['code']=1;
        $ret['meta']['data']=$goods;
        echo json_encode($ret);
    }

    public function update(Request $request,$id)
    {
        $params=$request->all();
        $themes=Themes::find($id);
        if($themes!=null){
            if ($request->hasFile('coverImage'))
            {
                $file = $request->file('coverImage');
                $fileName=md5(uniqid()).'.'.$file->getClientOriginalExtension();
                $file->move(base_path().'/public/upload',$fileName);


                $params['cover']='/upload/'.$fileName;
            }
            unset($params['coverImage']);

            if ($request->hasFile('headImage'))
            {
                $file = $request->file('headImage');
                $fileName=md5(uniqid()).'.'.$file->getClientOriginalExtension();
                $file->move(base_path().'/public/upload',$fileName);


                $params['head_image']='/upload/'.$fileName;
            }
            unset($params['headImage']);
            unset($params['_token']);

            $params['category_id']=$params['category'];
            unset($params['category']);

            if($params['type']==1){
                $params['themes_description']=$params['description'];
                unset($params['description']);
            }


            $chooseGoods=$params['chooseGoods'];
            unset($params['chooseGoods']);

            foreach($params as $n=>$p){
                $themes->$n=$p;
            }
            $themes->save();
            ThemeGoods::where('theme_id',$themes->id)->delete();
            $len=strlen($chooseGoods);
            if($len>0){
                $chooseGoods=substr($chooseGoods,0,$len-1);
                $chooseGoods=explode(',',$chooseGoods);
                foreach($chooseGoods as $i){
                    $themeGoods=new ThemeGoods();
                    $themeGoods->goods_id=$i;
                    $themeGoods->theme_id=$themes->id;
                    $themeGoods->save();
                }
            }
        }
        return redirect()->action('Admin\ThemesController@show');
    }

    public function delete($id)
    {
        $sub=SubjectThemes::where('theme_id',$id)->first();
        if($sub!=null){
            $ret['meta']['code']=0;
            $ret['meta']['error']='删除失败，该商品已绑定到专题，对应id为'.$sub->subject_id;
            echo json_encode($ret);
            return;
        }

        $home=Home::where('item_id',$id)->where('type',1)->first();
        if($home!=null){
            $ret['meta']['code']=0;
            $ret['meta']['error']='删除失败，该主题已绑定到首页，对应id为'.$home->id;
            echo json_encode($ret);
            return;
        }
        Themes::find($id)->delete();
        $ret['meta']['code']=1;
        echo json_encode($ret);
    }
}
