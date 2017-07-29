/**
 * Created by daniel on 3/7/17.
 */

//For global variables

var IS_SERVER = false;
var _URL = null;

var _PAGENAME = ["index","profile", "search"];

if(IS_SERVER){
    _URL = "https://www.wintle.co.kr/";
}else{
    _URL = "http://localhost/";
}


//var _URL = "https://www.wintle.co.kr/";
