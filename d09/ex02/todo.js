var		ft_list;
var		cookie = [];

window.onload = function () {
	deleteAllCookies();
	document.querySelector("#newTodo").addEventListener("click", newTodo);
	ft_list = document.querySelector("#ft_list");
	var tmp = document.cookie;
	console.log(tmp);
	if (tmp)
	{
		cookie = JSON.parse(tmp);
		cookie.forEach(function(task){addTodo(task);});
		// cookie.forEach(task => console.log(task));
	}
}

window.onunload = function () {
    var todo = ft_list.children;
    var newCookie = [];
    for (var i = 0; i < todo.length; i++)
        newCookie.unshift(todo[i].innerHTML);
    document.cookie = JSON.stringify(newCookie);
};

function newTodo() {
	console.log("newtodo");
	var todo = prompt("give todo");
	if (todo == '')
		return;
	var newdiv = document.createElement("div");
	newdiv.innerHTML = todo;
	newdiv.addEventListener("click", deleteTodo);
	ft_list.insertBefore(newdiv, ft_list.firstChild);
}
function deleteTodo() {
	if (confirm("confirm")){
		this.parentElement.removeChild(this);
	}
}

function deleteAllCookies() {
    var cookies = document.cookie.split(";");

    for (var i = 0; i < cookies.length; i++) {
        var cookie = cookies[i];
        var eqPos = cookie.indexOf("=");
        var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
        document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT";
    }
}
