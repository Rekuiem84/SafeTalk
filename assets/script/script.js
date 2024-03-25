const Burger = document.querySelector(".burger");
const NavMenu = document.querySelector(".nav__list");

Burger.addEventListener("click", () => {
	Burger.classList.toggle("open");
	NavMenu.classList.toggle("open");
});
