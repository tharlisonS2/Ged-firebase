<?php  
 namespace App\Http\Middleware;  
 use Illuminate\Support\Facades\Session;
 use Illuminate\Http\Request; 
 use Closure;  
 class Firebase  
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
     if(Session::has('firebaseUserId'))  
       return $next($request);  
     else  
       return redirect('/');  
   }  
 } 