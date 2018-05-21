function showdiv2(targetid,objN){
      var target=document.getElementById(targetid);
      var clicktext=document.getElementById(objN)

            if (target.style.display=="block"){
                target.style.display="none";
                clicktext.innerText="点击这里自定义分类信息";
 

            } else {
                target.style.display="block";
                clicktext.innerText='点击这里自定义分类信息';
            }
}
