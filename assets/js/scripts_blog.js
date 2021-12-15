/*!
* Start Bootstrap - Clean Blog v6.0.4 (https://startbootstrap.com/theme/clean-blog)
* Copyright 2013-2021 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-clean-blog/blob/master/LICENSE)
*/
window.addEventListener('DOMContentLoaded', () => {
    let scrollPos = 0;
    const mainNav = document.getElementById('mainNav');
    const headerHeight = mainNav.clientHeight;
    window.addEventListener('scroll', function () {
        const currentTop = document.body.getBoundingClientRect().top * -1;
        if (currentTop < scrollPos) {
            // Scrolling Up
            if (currentTop > 0 && mainNav.classList.contains('is-fixed')) {
                mainNav.classList.add('is-visible');
            } else {
                console.log(123);
                mainNav.classList.remove('is-visible', 'is-fixed');
            }
        } else {
            // Scrolling Down
            mainNav.classList.remove(['is-visible']);
            if (currentTop > headerHeight && !mainNav.classList.contains('is-fixed')) {
                mainNav.classList.add('is-fixed');
            }
        }
        scrollPos = currentTop;
    });
})

/* 
Character counter
*/
function limiting(oEvent) {
    if(isNaN(this.maxLength) == false){ 
      let oDiv =  document.getElementById(this.name+"Error");
      if(oDiv){
        let oCnt = oDiv.children[0],
            iLongueur = this.value.length,
            iLimit = this.maxLength;
        if(iLimit - iLongueur < 0) {
          oCnt.classList.add("warning");
        }else{
          oCnt.classList.remove("warning");
        }
        oCnt.textContent = iLongueur;
      }
    }
  }
  
  function limitingData(oEvent) {
    if(isNaN(this.dataset.maxlength) == false){ 
      let oDiv =  document.getElementById(this.name+"Error");
      if(oDiv){
        let oCnt =  oDiv.children[0], 
            iLongueur = this.value.length,
            iLimit = parseInt(this.dataset.maxlength);  
        if(iLimit - iLongueur < 0) {
          oCnt.classList.add("warning");
          oCnt.textContent = iLimit - iLongueur ;
        }else{
          oCnt.classList.remove("warning");
          oCnt.textContent = iLongueur ;
        }
      }
    }
  }
  
  
  document.addEventListener('DOMContentLoaded',function(){
    let aTextarea = document.getElementsByTagName('textarea');
    for(let oTextarea of aTextarea){
      if(oTextarea.maxLength != -1 && oTextarea.dataset.maxlength == null){
        //Avec un attribut maxlength
        oTextarea.addEventListener('input',limiting);
      }else if(oTextarea.maxLength == -1 && oTextarea.dataset.maxlength != null){
        //Sans limite bloquante
        oTextarea.addEventListener('input',limitingData); 
      }
    }
  });  
