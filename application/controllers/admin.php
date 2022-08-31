<?php
 
    class admin extends framework{
        public function login(){
            $username=$this->input('username');
            $password=$this->input('password');
            $password =MD5($password);
            $data=[$username,$password];
            $result = $this->model("adminModel");
            $check = $result->login($data);
            if($check){
                $this->set_session('ADMIN_ID', $check->admin_id);
                $this->flash('success','Admin Login Successfully.');
                $this->redirect('admin/dashboard');
            }
            else{
                $this->flash('warning','Credentials Not Macthed.');
                $this->redirect('admin');
            }
        }

        public function index(){
            $this->view('admin/login');
        }
        
        public function addPost(){
            if($this->middelware('ADMIN_ID')){
                $this->view('admin/addPost');
            }
            else{
                $this->redirect('admin');
            }
            
        }

        public function addUser(){
            if($this->middelware('ADMIN_ID')){
                $this->view('admin/users/addUser');
            }
            else{
                $this->redirect('admin');
            }
            
        }

        public function Dashboard(){
            if($this->middelware('ADMIN_ID')){
                $result = $this->model("blogModel");
                $data = $result->fetchBlog();
                if($data){
                    $this->view('admin/dashboard',$data);
                }
                else{
                    $this->view('admin/dashboard',$data =[]);
                }
            }
            else{
                $this->redirect('admin');
            }
        }
        public function user_list(){
            if($this->middelware('ADMIN_ID')){
                $result = $this->model("UserModel");
                $data = $result->fetchUsers();
                 
                if($data){
                    $this->view('admin/users/user_list',$data);
                }
                else{
                    $this->view('admin/users/user_list',$data =[]);
                }
            }
            else{
                $this->redirect('admin');
            }
}

public function delete_user($id){
    if($this->middelware('ADMIN_ID')){
        $result = $this->model("UserModel");
        $data = $result->deleteUser($id);
        if($id){
            $this->flash('success','User Deleted Successfully');
            $this->redirect('admin/dashboard');
        }
        else{
            $this->flash('warning','Something went wrong');
            $this->redirect('admin/dashboard');
        }
    }
    else{
        $this->redirect('admin');
    }
}

        public function delete($id){
            if($this->middelware('ADMIN_ID')){
                $result = $this->model("adminModel");
                $data = $result->deleteBlog($id);
                if($id){
                    $this->flash('success','Data Deleted Successfully');
                    $this->redirect('admin/dashboard');
                }
                else{
                    $this->flash('warning','Something went wrong');
                    $this->redirect('admin/dashboard');
                }
            }
            else{
                $this->redirect('admin');
            }
        }
        public function search_user(){
            $keyword = $this->input('keyword');
            $data = ["%$keyword%","%$keyword%"];
            $result = $this->model("UserModel");
            $row = $result->searchUser($data);
            $this->view('searchUser',$row);
        }

 public function updateUser_method(){
    if($this->middelware('ADMIN_ID')){
        $id = $this->input('id');
        $firstname=$this->input('firstname');
        $lastname=$this->input('lastname');
        $role=$this->input('role');
        $data=[$firstname,$lastname,$role,$id];
        $result = $this->model("UserModel",$data); 
        $test = $result->updateUser($data);
        if($test){
                $this->flash('success','User Updated Successfully');
                $this->redirect('admin/user_list'); 
                }
            else{
                $this->flash('success','User Updated Successfully');
                $this->redirect('admin/user_list');
                } 
        }
 }
 public function  insert_user(){
    if($this->middelware('ADMIN_ID')){
        $firstname=$this->input('firstname');
        $lastname=$this->input('lastname'); 
        $role=$this->input('role'); 
            
            $data=[$firstname,$lastname,$role];
            $result = $this->model("adminModel",$data);
            $result->insertUser($data);
            if($data){
                $this->flash('success','User Inserted Successfully');
                $this->redirect('admin/user_list');
            } 
            else{
                $this->flash('warning','Something went wrong');
                $this->redirect('admin/user_list');
            }
        }
        $this->redirect('admin');
}



        public function edit($id){
            if($this->middelware('ADMIN_ID')){
                $result = $this->model("blogModel");
                $data = $result->fetchPost($id);
                if($data){
                    $this->view('admin/edit_post',$data);
                }
            }
       }





       public function editUser($id){
        if($this->middelware('ADMIN_ID')){
            $result = $this->model("UserModel");
            $data = $result->fetchUser($id);
            if($data){
                $this->view('admin/users/edit_user',$data);
            }
        }
   }
   
       
        public function update(){
            if($this->middelware('ADMIN_ID')){
                $title=$this->input('title');
                $blog_id=$this->input('blog_id');
                $description=$this->input('description');
                $dttm = CURRENT_DATE_TIME; 
                if($this->hasfile('image')) {
                    $image = $this->hasfile('image');
                    if(!empty($image['name'])){                
                        if($this->extention($image)){
                            $img =$this->extention($image);
                            if($this->uploadfile($image)){
                                $data=[$title,$description,$img,$dttm,$blog_id];
                                $result = $this->model("adminModel",$data);
                                $chk=$result->updatePost_image($data);
                                
                                $this->flash('success','Data Updated Successfully');
                                $this->redirect('admin/Dashboard');
                            }
                        }
                        else{
                            $this->flash('danger','file must be in valid format');
                            $this->redirect('admin/Dashboard');
                        }
                    }
                    else{
                        $data=[$title,$description,$dttm,$blog_id];
                        $result = $this->model("adminModel",$data);
                        $chk = $result->updatePost($data);

                        $this->flash('success','Data Updated Successfully');
                        $this->redirect('admin/Dashboard');
                    }                    
                } 
            }
            else{
                $this->redirect('admin');
            }
        }



        public function  insert(){
            if($this->middelware('ADMIN_ID')){
                $title=$this->input('title');
                $description=$this->input('description');
                $dttm = CURRENT_DATE_TIME;

                if(empty($title)){
                    $error['error_msg']['title'] = $this->error('This field  is reuired');
                }
                
                if(empty($description)){
                    $error['error_msg']['description'] = $this->error('This field  is reuired');
                }
                if(!empty($title)){
                    $error['set_input']['title'] =  $title;
                }
                if(!empty($description)){
                    $error['set_input']['description'] =  $description;
                }

                if(isset($error['error_msg'] ) && $error['error_msg'] !='') {
                    $this->view('admin/addPost',$error);
                }
                else{
                    if($this->hasfile('image')) {
                        $image = $this->hasfile('image');
                        if(!empty($image['name'])){
                            if($this->extention($image)){
                                if($this->uploadfile($image)){
                                    $img =$this->extention($image);
                                    $data=[$title,$description,$img,$dttm];
                                    $result = $this->model("adminModel",$data);
                                    $result->insertBlog($data);
                                    if($data){
                                        $this->flash('success','Data Inserted Successfully');
                                        $this->redirect('admin/addPost');
                                    }
                                    else{
                                        $this->flash('warning','Something went wrong');
                                        $this->redirect('admin/addPost');
                                    }
                                }
                            }
                            else{
                                $error['error_msg']['image'] = $this->error('file must be in valid format');
                                $this->view('admin/addPost',$error);
                            }
                            
                        }
                    
                    }
                    else{
                        $error['error_msg']['image'] = $this->error('This field  is reuired');
                        $this->view('admin/addPost',$error);
                    }

                    
                }
            }
            else{
                $this->redirect('admin');
            }
        }
        

        public function logout(){
            $this->redirect('admin');
            session_destroy();
        }
    }
?>