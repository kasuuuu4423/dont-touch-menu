window.onload = () => {
  let input_file = document.getElementById('inputGroupFile01');
  if (input_file) {
    input_file.addEventListener('change', (event) => {
      let input_filename = input_file.files[0]['name'];
      console.log(input_filename);
      let input_file_label = document.getElementsByClassName('custom-file-label')[0];
      console.log(input_file_label.innerHTML);
      input_file_label.innerHTML = input_filename;
    });
  }
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