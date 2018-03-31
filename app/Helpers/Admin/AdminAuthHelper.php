<?php

namespace App\Helpers\Admin;

class AdminAuthHelper
{    
    public static function countPermissions($permissions) {
        $permissions = explode(",", $permissions);
        $adminUserPermissions = session()->get('admin.auth.admin-user.permissions');
        
        // Merge permissions array
        $adminUserPermissions = AdminAuthHelper::mergePermissionsArray($adminUserPermissions);
        
        $count = 0;
        foreach ($permissions as $permission) {
            if(in_array($permission, $adminUserPermissions))
                $count++;
        }
        return $count;
    }
    public static function hasPermission($permission, $type=null){
        $permissions = session()->get('admin.auth.admin-user.permissions');
        if($type){
            if(isset($permissions[$type])){
                if(in_array($permission, $permissions[$type])){
                    return true;
                }
            }
        }else{
            // Merge permissions array
            $permissions = AdminAuthHelper::mergePermissionsArray($permissions);
    
            if(in_array($permission, $permissions)){
                return true;
            }
        }
        return false;
    }
    public static function hasAnyPermissions($permissions, $type = null) {
        $permissions = explode(",", $permissions);
        $adminUserPermissions = session()->get('admin.auth.admin-user.permissions');
        
        if($type){
            if(isset($adminUserPermissions[$type])){
                foreach ($permissions as $permission) {
                    if(in_array($permission, $adminUserPermissions[type]))
                        return true;
                }
            }
        }else{
            // Merge permissions array
            $adminUserPermissions = AdminAuthHelper::mergePermissionsArray($adminUserPermissions);
            
            foreach ($permissions as $permission) {
                if(in_array($permission, $adminUserPermissions))
                    return true;
            }
        }
        
        return false;
    }
    
    public static function hasAllPermissions($permissions) {
        $permissions = explode(",", $permissions);
        $adminUserPermissions = session()->get('admin.auth.admin-user.permissions');
        
        // Merge permissions array
        $adminUserPermissions = AdminAuthHelper::mergePermissionsArray($adminUserPermissions);
        
        foreach ($permissions as $permission) {
            if(!(in_array($permission, $adminUserPermissions)))
                return false;
        }
        return true;
    }
    public static function hasType($type)
    {
        // Return boolean
        return (session()->get('admin.auth.admin-user.type') & $type);
    }
    
    private static function mergePermissionsArray($permissions){
        $result=array();
        foreach ($permissions as $subPermissions){
            $result=array_merge($result, $subPermissions);
        }
        $permissions = $result;
        
        return $permissions;
    } 
 
}

