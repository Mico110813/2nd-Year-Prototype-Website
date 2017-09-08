function getArticle() {
	var disttobottom=getDocHeight()-(getWinHeight()+getScrollPosition());
	if(disttobottom<=50){ // User has scrolled to bottom
		var main=document.getElementById("blog");
		var lastchild=main.children.length-1;
		var lastarticle=main.children[lastchild].id.substr(1);
		var timeelements=main.children[lastchild].getElementsByTagName("time");
		var blogpostdate=timeelements[0].getAttribute("datetime");
		console.log(blogpostdate);
		// create an XMLHTTPRequest
		var XHR=createXHR();
		XHR.open("POST","../DragonAcademyWebsiteV2/php/getarticle.php",true);
		XHR.onreadystatechange = (function() 
		{
			// IE8 requires readyState as separate check as status does
			// not exist until readyState==4
			if(XHR.readyState==4) {
				if(XHR.status==200) { // Two stage status check for IE8 support
					// Get json array returned					
					var responsedata=JSON.parse(XHR.responseText)[0];
					// Will be 0 if there are no more articles
					if(parseInt(responsedata.articleid)!=0 && responsedata.articleid) { 
						// create new article
						var newarticle=document.createElement("article");
						newarticle.setAttribute("id","a"+responsedata.articleid);
						main.appendChild(newarticle);
						// populate new article with content
						newarticlestr="<h1>"+responsedata.articletitle+"</h1><p>"+responsedata.articletext+"</p><footer><p>Posted on <time datetime='"+responsedata.blogtime+"'>"+responsedata.blogtime+" by <em>"+responsedata.username+"</em></p></footer>";
						newarticle.innerHTML=newarticlestr;	
						if((responsedata.currentuser.userid==responsedata.blogposter && responsedata.currentuser.userlevel>1)|| responsedata.currentuser.userlevel>2) {
							var deletelink=document.createElement("p");
							deletelink.innerHTML="<a href='deletearticle.php?aID="+responsedata.articleid+"' id='db"+responsedata.articleid+"'>Delete Post</a>";
							newarticle.appendChild(deletelink);
						}

					}
				}else if(XHR.status==400) {
					alert("Could not request data");
				}
			}
		});
		// Send request
		XHR.setRequestHeader("Content-type","application/x-www-form-urlencoded");
		XHR.send("blogpostdate="+encodeURIComponent(blogpostdate));
	}
}

function prepareArticle() {
	var checkPosition = setInterval(getArticle,1000);

}
