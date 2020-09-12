window.onload = () => {
    let input_file = document.getElementById('inputGroupFile01');
    input_file.addEventListener('change', (event) => {
        let input_filename = input_file.files[0]['name'];
        console.log(input_filename);
        let input_file_label = document.getElementsByClassName('custom-file-label')[0];
        console.log(input_file_label.innerHTML);
        input_file_label.innerHTML = input_filename;
    });
}