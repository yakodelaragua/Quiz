$(document).ready(function () {
    XMLHttpRequestObjectUsu = new XMLHttpRequest();
    XMLHttpRequestObjectUsu.open("POST", 'Counter.php', true);
    XMLHttpRequestObjectUsu.send(null);
    XMLHttpRequestObjectUsu.onreadystatechange = function () {
        if (XMLHttpRequestObjectCuantas.readyState == 4) {
            var obj = document.getElementById('nusuarios');
            obj.innerHTML = XMLHttpRequestObjectUsu.responseText;
        }
    }



    setInterval(function(){ 
        var valAnt = document.getElementById('nusuarios').textContent;
        
        XMLHttpRequestObjectUsu.open("POST", 'Counter.php', true);
        XMLHttpRequestObjectUsu.send(null);
        XMLHttpRequestObjectUsu.onreadystatechange = function () {
            if (XMLHttpRequestObjectCuantas.readyState == 4) {
                var obj = document.getElementById('nusuarios');
                obj.innerHTML = XMLHttpRequestObjectUsu.responseText;
            }
        } }, 2000);
});



