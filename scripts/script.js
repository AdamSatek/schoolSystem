///////////////// PHOTOGALLERY

let galleryImages = document.querySelectorAll(".gallery-img");
let windowWidth = window.innerWidth;


if(galleryImages){
  galleryImages.forEach(function(image) {
    image.onclick = function() {
      let getImgUrl = this.style.backgroundImage;
      let getFullImgUrl = getImgUrl.split('photogallery/');
      let setNewImgUrl = getFullImgUrl[1].replace('")', '');
      let fullImgUrl = "photogallery/" + setNewImgUrl;

      let container = document.body;
      let newImgWindow = document.createElement("div");
      container.appendChild(newImgWindow);
      newImgWindow.setAttribute("class", "img-window");
     

      let newImg = document.createElement("img");
      newImgWindow.appendChild(newImg);
      newImg.setAttribute("src", fullImgUrl);
      newImg.setAttribute("name", setNewImgUrl);
      newImg.setAttribute("id", "full-img");

     
      let arrowLeft = document.createElement("div");
      newImgWindow.appendChild(arrowLeft);
      arrowLeft.setAttribute("class", "arrowLeft");
      arrowLeft.setAttribute("onclick", "changeImg(-1)");

      let arrowRight = document.createElement("div");
      newImgWindow.appendChild(arrowRight);
      arrowRight.setAttribute("class", "arrowRight");
      arrowRight.setAttribute("onclick", "changeImg(1)");

      let closeWindow = document.createElement("div");
      newImgWindow.appendChild(closeWindow);
      closeWindow.setAttribute("class", "close-window");
      closeWindow.setAttribute("onclick", "closeImg()");
      
    }
  });
}

function closeImg() {
  document.querySelector(".img-window").remove();
}


function changeImg(i) {
  actualImg = document.getElementById("full-img").name;

  function checkValue(x){
    return x == actualImg;
  }
  actualIndex = pictures.findIndex(checkValue);

  arrayLen = pictures.length;

  if(actualIndex == 0 && i == -1){
    newIndex = arrayLen - 1;
  } else if (actualIndex == arrayLen - 1 && i == 1) {
    newIndex = 0;
  } else {
    newIndex = actualIndex + i;
  };
  
  newImgName = pictures[newIndex];
  newImgSrc = "photogallery/" + newImgName;

  
  document.getElementById("full-img").name = newImgName;
  document.getElementById("full-img").src = newImgSrc;

}




