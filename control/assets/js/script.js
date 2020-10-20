import {sort_cat, sort_item} from './sort.js';

window.onload = () => {
  if(document.getElementById('btn_sort_cat' != null)){
    sort_cat();
  }
  if(document.getElementsByClassName('btn_sort_item')[0] != null){
    sort_item();
  }
  if(document.getElementById('btn_sort_cat') != null){
    fixed_btn_sort_cat();
  }
  if(document.getElementsByClassName('tgl_nav') != null){
    tgl_nav();
  }
  let input_file = document.getElementById('inputGroupFile01');
  if (input_file) {
    input_file.addEventListener('change', (event) => {
      let input_filename = input_file.files[0]['name'];
      let input_file_label = document.getElementsByClassName('custom-file-label')[0];
      input_file_label.innerHTML = input_filename;

      let file_data = input_file.files[0];
      let reader = new FileReader();
      reader.readAsDataURL(file_data);
      reader.onload = () => {
        let last_figure = document.getElementById('tmp_store_img');
        if(last_figure){
          last_figure.parentNode.removeChild(last_figure);
        }
        let input_group = document.getElementsByClassName('input-group');
        let row = input_group[0].parentNode;
        let figure = document.createElement('figure');
        let img = document.createElement('img');
        img.setAttribute('src', reader.result);
        img.setAttribute('class', 'w-100');
        figure.appendChild(img);
        figure.setAttribute('class', 'col-12');
        figure.setAttribute('id', 'tmp_store_img');
        row.insertBefore(figure, row.firstChild);
      }
    });
  }
  $(".toggle-password").click(function() {
    // iconの切り替え
    $(this).toggleClass("fa-eye fa-eye-slash");
  
    // 入力フォームの取得
    let input = $(this).parent().prev("input");
    // type切替
    if (input.attr("type") == "password") {
      input.attr("type", "text");
    } else {
      input.attr("type", "password");
    }
  });
}

const tgl_nav = () => {
  let btns_tgl = document.getElementsByClassName('tgl_nav');
  for(let i = 0; i < btns_tgl.length; i++){
    btns_tgl[i].addEventListener('click', (e)=>{
      let row = e.target.parentNode.parentNode;
      let btns = row.getElementsByClassName('btns')[0];
      let btns_style = document.defaultView.getComputedStyle(btns,null).display;
      if(btns_style == 'none'){
        btns.classList.remove('d-none');
        e.target.innerHTML = '編集△';
      }
      else{
        btns.classList.add('d-none');
        e.target.innerHTML = '編集▽';
      }
    });
  }
}

let flg_offset = true;
let empty;
const fixed_btn = (btn, btn_y) => {
    if(window.pageYOffset > btn_y){
        if(flg_offset){
            btn.classList.add('fixed');
            flg_offset = false;
        }
    }
    else{
        if(!flg_offset){
            btn.classList.remove('fixed');
            flg_offset = true;
        }
    }
}

const fixed_btn_sort_cat = () => {
  let btns_cat = document.getElementById("btns_cat");
  let btns_rect = btns_cat.getBoundingClientRect();
  let y = window.pageYOffset + btns_rect.top;
  console.log(y);
  window.addEventListener('scroll', ()=>{fixed_btn(btns_cat, y)}, false);
}

const fadeIn = (node, duration) => {
  // display: noneでないときは何もしない
  if (getComputedStyle(node).display !== 'none') return;
  
  // style属性にdisplay: noneが設定されていたとき
  if (node.style.display === 'none') {
    node.style.display = '';
  } else {
    node.style.display = 'block';
  }
  node.style.opacity = 0;

  var start = performance.now();
  
  requestAnimationFrame(function tick(timestamp) {
    // イージング計算式（linear）
    var easing = (timestamp - start) / duration;

    // opacityが1を超えないように
    node.style.opacity = Math.min(easing, 1);

    // opacityが1より小さいとき
    if (easing < 1) {
      requestAnimationFrame(tick);
    } else {
      node.style.opacity = '';
    }
  });
}