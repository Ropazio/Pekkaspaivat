// Tekstikenttä näkyville napin painalluksesta. //

var coll = document.getElementsByClassName("kenttatoiminto");
var i;

for (i = 0; i < coll.length; i++) {
	coll[i].addEventListener("click", function() {
		var kentta = this.nextElementSibling;
		if (kentta == null)
			return;

		this.classList.toggle("active");
		kentta.style.display = "block";
	});
}