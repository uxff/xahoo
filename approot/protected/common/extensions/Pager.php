<?php 
    class Pager{ 
        /**页码**/ 
        public $pageNo = 1; 
        /**页大小**/ 
        public $pageSize = 20; 
        /**共多少页**/ 
        public $pageCount = 0; 
        /**总记录数**/ 
        public $totalNum = 0; 
        /**偏移量,当前页起始行**/ 
        public $offSet = 0; 
        /**每页数据**/ 
        public $pageData = ''; 
         
        /**是否有上一页**/ 
        public $hasPrePage = true; 
        /**是否有下一页**/ 
        public $hasNextPage = true; 
         
        public $pageNoList = array(); 
         
        /** 
         *  
         * @param unknown_type $count 总行数 
         * @param unknown_type $size 分页大小 
         * @param unknown_type $string 
         */ 
        public function __construct($count=0, $size=20,$pageNo=1,$pageData =''){ 
     
            $this->totalNum = $count;//总记录数 
            $this->pageSize = $size;//每页大小 
            $this->pageNo = $pageNo; 
            //计算总页数 
            $this->pageCount = ceil($this->totalNum/$this->pageSize); 
            $this->pageCount = ($this->pageCount<=0)?1:$this->pageCount; 
            //检查pageNo 
            $this->pageNo = $this->pageNo <= 0 ? 1 : $this->pageNo; 
            $this->pageNo = $this->pageNo > $this->pageCount? $this->pageCount : $this->pageNo; 
             
            //计算偏移 
            $this->offset = ( $this->pageNo - 1 ) * $this->pageSize; 
            //计算是否有上一页下一页 
            $this->hasPrePage = $this->pageNo == 1 ?false:true;  
     
            $this->hasNextPage = $this->pageNo >= $this->pageCount ?false:true; 
             
            $this->pageData = $pageData; 
             
        } 
        /** 
         * 分页算法 
         * @return 
         */ 
        private function generatePageList(){ 
            $pageList = array(); 
            if($this->pageCount <= 5){ 
                for($i=0;$i<$this->pageCount;$i++){ 
                    array_push($pageList,$i+1); 
                } 
            }else{ 
                if($this->pageNo <= 4){ 
                    for($i=0;$i<5;$i++){ 
                        array_push($pageList,$i+1); 
                    } 
                    array_push($pageList,-1); 
                    array_push($pageList,$this->pageCount); 
     
                }else if($this->pageNo > $this->pageCount - 4){ 
                    array_push($pageList,1); 
                     
                    array_push($pageList,-1); 
                    for($i=5;$i>0;$i--){ 
                        array_push($pageList,$this->pageCount - $i+1); 
                    } 
                }else if($this->pageNo > 4 && $this->pageNo <= $this->pageCount - 4){ 
                    array_push($pageList,1); 
                    array_push($pageList,-1); 
                     
                    array_push($pageList,$this->pageNo -2); 
                    array_push($pageList,$this->pageNo -1); 
                    array_push($pageList,$this->pageNo); 
                    array_push($pageList,$this->pageNo + 1); 
                    array_push($pageList,$this->pageNo + 2); 
                     
                    array_push($pageList,-1); 
                    array_push($pageList,$this->pageCount); 
                     
                } 
            } 
            return $pageList; 
        } 
     
        /*** 
         * 创建分页控件 
        * @param 
        * @return String 
        */ 
        public function echoPageAsDiv(){ 
            $pageList = $this->generatePageList(); 
            $pageString = '';
            $sign = strstr($this->pageData,'?') ? '&narrow=true&' : '?narrow=true&';
            if($this->pageCount >1){ 
	            $pageString ='<div class="text-center"><ul class="pagination h-house-page"><li class="h-page-all">共'.$this->pageCount.'页</li>'; 
	         
	            if(!empty($pageList)){ 
	                
	                    if($this->hasPrePage){ 
	                        $pageString = $pageString ."<li><a  href=\" " . $this->pageData.$sign."page_no=". ($this->pageNo-1) . " \">上一页</a></li>"; 
	                    } else {
	                    	$pageString = $pageString ."<li class=\"h-pag-grey\">上一页</li>"; 
	                    }
	                    foreach ($pageList as $k=>$p){ 
	                        if($this->pageNo == $p){ 
	                            $pageString = $pageString ."<li class=\"active\">" . $this->pageNo . "</li>"; 
	                            continue; 
	                        } 
	                        if($p == -1){ 
	                            $pageString = $pageString ."<li><a>...</a></li>"; 
	                            continue; 
	                        } 
	                        $pageString = $pageString ."<li><a href=\" "  . $this->pageData.$sign."page_no=". $p . " \">" . $p . "</a></li>"; 
	                    } 
	                     
	                    if($this->hasNextPage){ 
	                    	$pageString = $pageString ."<li><a  href=\" " . $this->pageData.$sign."page_no=".($this->pageNo+1) . " \">下一页</a></li>"; 
	                    } else {
	                    	$pageString = $pageString ."<li class=\"h-pag-grey\">下一页</li>"; 
	                    }
	                     
	                } 
            } 
            $pageString = $pageString .("</ul></div>"); 
            return $pageString; 
        } 
        
        /***
         * 创建分页控件
         * @param
         * @return String
         */
        public function echoNewPageAsDiv(){
            $pageList = $this->generatePageList();
            $pageString = '';
            $sign = strstr($this->pageData,'?') ? '&narrow=true&' : '?narrow=true&';
            $pageString ='<div class="new_page"><ul class="pagination h-house-page"><li class="h-page-all"><a>共'.$this->pageCount.'页</a></li>';
            if($this->pageCount >1){
                if(!empty($pageList)){
                    if($this->hasPrePage){
                        $pageString = $pageString ."<li><a  href=\" " . $this->pageData.$sign."page_no=". ($this->pageNo-1) . " \">上一页</a></li>";
                    } else {
                        $pageString = $pageString ."<li class=\"h-pag-grey\"><a>上一页</a></li>";
                    }
                    foreach ($pageList as $k=>$p){
                        if($this->pageNo == $p){
                            $pageString = $pageString ."<li class=\"active\"><a>" . $this->pageNo . "</a></li>";
                            continue;
                        }
                        if($p == -1){
                            $pageString = $pageString ."<li><a>...</a></li>";
                            continue;
                        }
                        $pageString = $pageString ."<li><a href=\" "  . $this->pageData.$sign."page_no=". $p . " \">" . $p . "</a></li>";
                    }
        
                    if($this->hasNextPage){
                        $pageString = $pageString ."<li><a  href=\" " . $this->pageData.$sign."page_no=".($this->pageNo+1) . " \">下一页</a></li>";
                    } else {
                        $pageString = $pageString ."<li class=\"h-pag-grey\"><a>下一页</a></li>";
                    }
        
                }
            }
            $pageString = $pageString .("</ul></div>");
            return $pageString;
        }
        
    } 
     
?> 