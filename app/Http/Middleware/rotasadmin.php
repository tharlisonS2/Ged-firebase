<?php  
 namespace App\Http\Middleware;  
 use Illuminate\Support\Facades\Session;
 use Illuminate\Http\Request; 
 use Closure;  
 class rotasadmin  
 {  
   /**  
    * Handle an incoming request.  
    *  
    * @param \Illuminate\Http\Request $request  
    * @param \Closure $next  
    * @return mixed  
    */  
   public function handle( $request, Closure $next)  
   {  
     if(Session::has('firebaseUserId')&&Session::get('admin')==true)  
       return $next($request);  
     else  
       return redirect('/');  
   }  
 } 