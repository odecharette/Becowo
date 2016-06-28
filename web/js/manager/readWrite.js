function goWrite($element)
	{
		var x = document.getElementsByClassName("read-"+$element);
		var i;
		for (i = 0; i < x.length; i++) {
		    x[i].style.display = "none";
		}
		var x = document.getElementsByClassName("write-"+$element);
		var i;
		for (i = 0; i < x.length; i++) {
		    x[i].style.display = "block";
		}
	}

function goRead($element)
{
	var x = document.getElementsByClassName("read-"+$element);
	var i;
	for (i = 0; i < x.length; i++) {
	    x[i].style.display = "block";
	}
	var x = document.getElementsByClassName("write-"+$element);
	var i;
	for (i = 0; i < x.length; i++) {
	    x[i].style.display = "none";
	}
}
