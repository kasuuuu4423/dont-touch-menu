import {fixed_btn_sort_cat, sort_cat, sort_item} from './sort.js';

window.onload = () => {
  if(document.getElementById('btn_sort')){
    sort_cat();
  }
  if(document.getElementsByClassName('btn_sort_item')[0]){
    sort_item();
  }
  if(document.getElementById('btn_sort_cat')){
    fixed_btn_sort_cat();
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
