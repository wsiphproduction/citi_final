
$(function(){
	("use strict");

	feather.replace();

	////////// NAVBAR //////////

	// Initialize PerfectScrollbar of navbar menu for mobile only
	// if(window.matchMedia('(max-width: 991px)').matches) {
	//   const psNavbar = new PerfectScrollbar('#navbarMenu', {
	//     suppressScrollX: true
	//   });
	// }

	// Showing sub-menu of active menu on navbar when mobile
	function showNavbarActiveSub() {
		if (window.matchMedia("(max-width: 991px)").matches) {
			$("#navbarMenu .active").addClass("show");
		} else {
			$("#navbarMenu .active").removeClass("show");
		}
	}

	showNavbarActiveSub();
	$(window).resize(function () {
		showNavbarActiveSub();
	});

	// Initialize backdrop for overlay purpose
	$("body").append('<div class="backdrop"></div>');

	// Showing sub menu of navbar menu while hiding other siblings
	$(".navbar-menu .with-sub .nav-link").on("click", function (e) {
		e.preventDefault();
		$(this).parent().toggleClass("show");
		$(this).parent().siblings().removeClass("show");

		if (window.matchMedia("(max-width: 991px)").matches) {
			psNavbar.update();
		}
	});

	// Closing dropdown menu of navbar menu
	$(document).on("click touchstart", function (e) {
		e.stopPropagation();

		// closing nav sub menu of header when clicking outside of it
		if (window.matchMedia("(min-width: 992px)").matches) {
			var navTarg = $(e.target).closest(".navbar-menu .nav-item").length;
			if (!navTarg) {
				$(".navbar-header .show").removeClass("show");
			}
		}
	});

	$("#mainMenuClose").on("click", function (e) {
		e.preventDefault();
		$("body").removeClass("navbar-nav-show");
	});

	$("#sidebarMenuOpen").on("click", function (e) {
		e.preventDefault();
		$("body").addClass("sidebar-show");
	});

	// Navbar Search
	$("#navbarSearch").on("click", function (e) {
		e.preventDefault();
		$(".navbar-search").addClass("visible");
		$(".backdrop").addClass("show");
	});

	$("#navbarSearchClose").on("click", function (e) {
		e.preventDefault();
		$(".navbar-search").removeClass("visible");
		$(".backdrop").removeClass("show");
	});

	////////// SIDEBAR //////////

	// Initialize PerfectScrollbar for sidebar menu
	if ($("#sidebarMenu").length) {
		const psSidebar = new PerfectScrollbar("#sidebarMenu", {
			suppressScrollX: true,
		});

		// Showing sub menu in sidebar
		$(".sidebar-nav .with-sub").on("click", function (e) {
			e.preventDefault();
			$(this).parent().toggleClass("show");

			psSidebar.update();
		});
	}

	$("#mainMenuOpen").on("click touchstart", function (e) {
		e.preventDefault();
		$("body").addClass("navbar-nav-show");
	});

	$("#sidebarMenuClose").on("click", function (e) {
		e.preventDefault();
		$("body").removeClass("sidebar-show");
	});

	// hide sidebar when clicking outside of it
	$(document).on("click touchstart", function (e) {
		e.stopPropagation();

		// closing of sidebar menu when clicking outside of it
		if (!$(e.target).closest(".burger-menu").length) {
			var sb = $(e.target).closest(".sidebar").length;
			var nb = $(e.target).closest(".navbar-menu-wrapper").length;
			if (!sb && !nb) {
				if ($("body").hasClass("navbar-nav-show")) {
					$("body").removeClass("navbar-nav-show");
				} else {
					$("body").removeClass("sidebar-show");
				}
			}
		}
	});

	if (
		window.matchMedia &&
		window.matchMedia("(prefers-color-scheme: dark)").matches
	) {
		$("head").append(
			'<link id="dfMode" rel="stylesheet" href="assets/css/skin.dark.css">'
		);
		$(".btn-white").addClass("btn-dark").removeClass("btn-white");
    $(".bg-white").addClass("bg-dark").removeClass("bg-white");
	}

	window
		.matchMedia("(prefers-color-scheme: dark)")
		.addEventListener("change", (e) => {
			const newColorScheme = e.matches ? "dark" : "light";

			if (newColorScheme === "light") {
				$("#dfMode").remove();
				$(".btn-dark").addClass("btn-white").removeClass("btn-dark");
        $(".bg-dark").addClass("bg-white").removeClass("bg-dark");
			} else {
				$("head").append(
					'<link id="dfMode" rel="stylesheet" href="assets/css/skin.dark.css">'
				);
				$(".btn-white").addClass("btn-dark").removeClass("btn-white");
        $(".bg-white").addClass("bg-dark").removeClass("bg-white");
			}
		});

	/*** Handles the Select All Checkbox ***/
	$("#checkbox_all").click(function () {
		$(".cb").not(this).prop("checked", this.checked);
		if (this.checked) {
			$(".row_cb").addClass("row-selected");
		} else {
			$(".row_cb").removeClass("row-selected");
		}
	});

	$(".cb").change(function () {
		var id = $(this).attr("id").replace("cb", "");
		if (this.checked) {
			$("#row" + id).addClass("row-selected");
		} else {
			$("#row" + id).removeClass("row-selected");
		}
	});

	$("#btnSearch").on("click", function () {
		$("#searchForm").submit();
	});
	/*** END END Handles the Select All Checkbox END END ***/
})
