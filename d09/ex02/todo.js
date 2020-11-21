var		ft_list;
var		cookie = [];

window.onload = function () {
	document.querySelector("#newTodo").addEventListener("click", newTodo);
	ft_list = document.querySelector("#ft_list");
	var tmp = document.cookie;
	tmp = tmp.substring(0, tmp.indexOf(";"));
	if (tmp)
	{
		cookie = JSON.parse(tmp);
		cookie.forEach(task => newTodo(task));
	}
}

window.onunload = function () {
    var todo = ft_list.children;
    var newCookie = [];
    for (var i = 0; i < todo.length; i++)
        newCookie.unshift(todo[i].innerHTML);
    document.cookie = JSON.stringify(newCookie);
}

function newTodo(arg) {
	if (arg && typeof(arg) != "object")
		todo = arg;
	else
		var todo = prompt("give task");
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
