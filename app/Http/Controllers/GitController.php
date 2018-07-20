<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;
use App\Libraries\Classes\TransferCode;
use App\Libraries\Classes\HttpClient;

class GitController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index(){
        $jsonData =file_get_contents("php://input");
        $tag = "git hooks";
        Log::info("[$tag]\t$jsonData");
        //记录请求信息
        $data = json_decode($jsonData,true);

        if( null == $data ){
            Log::info("[$tag]\tdata null srcdata:{$jsonData}");
            return ;
        }

        $commitId = isset($data['after']) ? $data['after'] : '';
        if( null == $commitId ) {
            Log::info("[$tag]\tcommit id null srcdata:{$jsonData}");
            return ;
        }

        //oschina
        if(isset($data['project']) ) {
            $project = isset($data['project']) ? $data['project'] : '';
            if( null == $project ) {
                Log::info("[$tag]\tproject null commit id:{$commitId}");
                return ;
            }
            $namespace= isset($project['namespace']) ? $project['namespace'] : '';
            if( null == $namespace ) {
                Log::info("[$tag]\tnamespace null commit id:{$commitId}");
                return ;
            }
            $name= isset($project['name']) ? $project['name'] : '';
            if( null == $name ) {
                Log::info("[$tag]\tname null commit id:{$commitId}");
                return ;
            }
        } else {
            $repository = isset($data['repository']) ? $data['repository'] : '';
            if( null == $repository ) {
                Log::info("[$tag]\trepository null commit id:{$commitId}");
                return ;
            }
            $full_name= isset($repository['full_name']) ? $repository['full_name'] : '';
            if( null == $full_name ) {
                Log::info("[$tag]\tfull_name null commit id:{$commitId}");
                return ;
            }
            list($namespace,$name) = explode('/',$full_name);
            if( null == $namespace ) {
                Log::info("[$tag]\tnamespace null commit id:{$commitId}");
                return ;
            }
            if( null == $name ) {
                Log::info("[$tag]\tname null commit id:{$commitId}");
                return ;
            }
        }

        
        $branch = isset($data['ref']) ? $data['ref'] : '';
        $branch = substr($branch,11);

        if( null == $branch ) {
            Log::info("[$tag]\tbranch null commit id:{$commitId}");
            return ;
        }

        

        $gitConf = config("git");
        //Log::info("[$tag]\tconf ".json_encode($gitConf));

        if( null == $gitConf || (!is_array($gitConf)) ){
            Log::info("[$tag]\tcommit id null commit id:{$commitId}");
            return ;
        }
        $curNamespace = null;
        foreach ($gitConf as $key => $value) {
            if( ($namespace == $key || $key == '*') && $value != null ) {
                $curNamespace = $value;
            }
        }
        if( null == $curNamespace || (!is_array($curNamespace)) ){
            Log::info("[$tag]\tconf {$namespace} null commit id:{$commitId}");
            return ;
        }

        $curName = null;
        foreach ($curNamespace as $key => $value) {
            if( ($name == $key || $key == '*') && $value != null ) {
                $curName = $value;
            }
        }
        if( null == $curName || (!is_array($curName)) ){
            Log::info("[$tag]\tconf {$namespace}/{$name} null commit id:{$commitId}");
            return ;
        }

        $curBranch = null;
        foreach ($curName as $key => $value) {
            if( ($branch == $key || $key == '*') && $value != null  ) {
                $curBranch = $value;
            }
        }
        if( null == $curBranch || (!is_array($curBranch)) ){
            Log::info("[$tag]\tconf {$namespace}/{$name} {$branch} null commit id:{$commitId}");
            return ;
        }
        $karr = array();
        $karr[] = '[namespace]'; 
        $karr[] = '[name]'; 
        $karr[] = '[branch]'; 
        $varr = array();
        $varr[] = $namespace; 
        $varr[] = $name; 
        $varr[] = $branch; 
                  
        foreach ($curBranch as $key => $value) {
            $cmd = $value;
            $cmd =  str_ireplace($karr,$varr,$cmd);
            $result = shell_exec($cmd);
            Log::info("[$tag]\tconf {$namespace}/{$name} {$branch} cmd:{$cmd} result:{$result} commit id:{$commitId}");
        }
    }
}