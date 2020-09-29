class Lib_menu{
    ajax(method, url, data, success_func = () => {}){
        let request = new XMLHttpRequest();
        request.open(method, url, true);
        request.onload = () => {
            if(request.status >= 200 && request.status < 400){
                success_func();
                console.log('done_ajax');
                // console.log(request.responseText);
                // return request.responseText;
            }
            else{
                console.log('error' + request.status);
            }
        }
        request.send(data);
    }
}

export default Lib_menu;