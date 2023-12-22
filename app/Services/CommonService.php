<?php

    namespace App\Services;
    use App\User;    
    use Hash;
    use Str;
    use App\Role;
    use App\Module;
    use App\RolePermission;

    Class CommonService
    {
        public function generate_slug()
        {
            do{
                $prefix = "LIFT";
                $id = $prefix.rand(00000,99999);
                $exist = User::where("userid", $id)->first();
            }while($exist);
            return $id;
        }
       
        public function check_permission($role,$slug,$type){
            $check_permission = RolePermission::where('slug',$slug)->where('role_id',$role)->first();
            if($check_permission != '')
            {
                $data = $this->permission($check_permission->permission);
                
                if($type == "LIST")
                {
                    if($data['VIEWALL'] == 1 || $data['VIEWOWN'] == 1)
                    {
                        $data['status'] = true;
                        return $data;
                    }else{
                        $falsedata['status'] = false;
                        return $falsedata;
                    }
                }elseif($type == "CREATE")
                {
                    if($data['CREATE'] == 1)
                    {
                        $data['status'] = true;
                        return $data;
                    }else{
                        $falsedata['status'] = false;
                        return $falsedata;
                    }
                }elseif($type == "EDIT")
                {
                    if($data['EDITALL'] == 1 || $data['EDITOWN'] == 1)
                    {
                        $data['status'] = true;
                        return $data;
                    }else{
                        $falsedata['status'] = false;
                        return $falsedata;
                    }
                }elseif($type == "DELETE")
                {
                    if($data['DELETE'] == 1 || $data['DELETEOWN'] == 1)
                    {
                        $data['status'] = true;
                        return $data;
                    }else{
                        $falsedata['status'] = false;
                        return $falsedata;
                    }
                }else{
                    $falsedata['status'] = false;
                        return $falsedata;
                }
            }
        }
        
        public function permission($array)
        {
            $permission_array = explode('|',$array);
            $viewall = $permission_array[0];
            $viewown = $permission_array[1];
            $create = $permission_array[2];
            $editall = $permission_array[3];
            $editown = $permission_array[4];
            $delete = $permission_array[5];
            $deleteown = $permission_array[6];
            
            $data['VIEWALL'] = ($viewall != 'none') ? 1: 0; 
            $data['VIEWOWN'] = ($viewown != 'none') ? 1: 0; 
            $data['CREATE'] = ($create != 'none') ? 1: 0; 
            $data['EDITALL'] = ($editall != 'none') ? 1: 0; 
            $data['EDITOWN'] = ($editown != 'none') ? 1: 0; 
            $data['DELETE'] = ($delete != 'none') ? 1: 0; 
            $data['DELETEOWN'] = ($deleteown != 'none') ? 1: 0; 
            return $data;
            
        }
    
    }
