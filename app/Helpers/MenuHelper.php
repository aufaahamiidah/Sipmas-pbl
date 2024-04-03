<?php

namespace App\Helpers;

use App\Models\Menu;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class MenuHelper
{
    public static function Menu()
    {
        // $user_role = DB::table('model_has_roles')->where('role_id', auth()->user()->role_id)->first();
        $user_role  = auth()->user()->role_id;
        $menu_roles = DB::table('role_has_menus')->where('role_id', $user_role)->get();

        $array_menu_roles = [];
        foreach ($menu_roles as  $value) {
            $array_menu_roles[] = $value->menu_id;
        }
        // $menus = Menu::where('id', $array_menu_roles);
        $menus = Menu::where('parent_id', 0)
            ->with('submenus', function ($query) use ($array_menu_roles) {
                $query->whereIn('id', $array_menu_roles);
                $query->with('submenus', function ($query) use ($array_menu_roles) {
                    $query->whereIn('id', $array_menu_roles);
                });
            })
            ->whereIn('id', $array_menu_roles)
            ->get();
        return json_encode($menus);
    }

    public static function getUsulanSkema()
    {
        $skema = DB::table("ref_jenis_skema")->get();
        $data = [];

        foreach ($skema as $key => $value) {
            $data[$key]["skema_id"] = $value->jenis_skema_id;
            $data[$key]["skema_icon"] = $value->jenis_skema_icon;
            $data[$key]["skema_color"] = $value->jenis_skema_color;
            $data[$key]["skema_nama"] = $value->jenis_skema_nama;
            $data[$key]["trx_skema"] = array();

            $trx_skema = DB::table("trx_skema")->where("jenis_skema_id", $value->jenis_skema_id)->get()->map(function ($item) {
                return [$item->trx_skema_nama];
            })->toArray();
            foreach ($trx_skema as $trxKey) {
                array_push($data[$key]["trx_skema"], $trxKey);
            }
        }
        return json_encode($data);
    }
}
