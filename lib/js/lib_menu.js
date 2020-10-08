class Lib_menu{
    elm_hidden_byElm(element){
        let elm = element;
        let dislay = elm.style.display;
        elm.style.display = 'none';
        return dislay;
    }
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