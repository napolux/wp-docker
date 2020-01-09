// add or remove apartment to or from favorites

const setCookie = (name, value, days = 7, path = "/") => {
	const expires = new Date(Date.now() + days * 864e5).toUTCString();
	document.cookie =
		name +
		"=" +
		encodeURIComponent(value) +
		"; expires=" +
		expires +
		"; path=" +
		path;
};

const getCookie = name => {
	return document.cookie.split("; ").reduce((r, v) => {
		const parts = v.split("=");
		return parts[0] === name ? decodeURIComponent(parts[1]) : r;
	}, "");
};

const deleteCookie = (name, path) => {
	setCookie(name, "", -1, path);
};

const saveToFavorite = name => {
	let favButton = document.querySelector(`div[data-post-id="${name}"]`);
	if (!getCookie(name)) {
		setCookie(name, "favourited");
		favButton.classList.add("active");
	//	favButton.parentElement.innerHTML = '1 <div>ddd</div>';
	} else {
		deleteCookie(name, "/");
		favButton.classList.remove("active");
	//	favButton.innerHTML += "0";
	}
};

const favBtns = Array.from(document.querySelectorAll(".fav-button"));
favBtns.forEach(favBtn => {
	const postId = favBtn.dataset.postId;
	const cookie = getCookie(postId);

	favBtn.addEventListener("click", () => saveToFavorite(`${postId}`));
	cookie && favBtn.classList.add("active");
});

// floorplans table

jQuery(document).ready(function ($) {
	$('#apartments').DataTable( {
		"searching": false,
		"lengthChange": false,
		"paging": false,
		"info": false,
		"columnDefs": [ {
			"targets": 1,
			"orderable": false
			} , {
				"targets": 9,
				"orderable": false
				} ]

	} );


	// Slick slider for neighborhood page

	$('.slider').slick({

	  });
});

// floorplans table>grid view

const tableViewButton = document.querySelector('.view_btn.table');
const gridViewButton = document.querySelector('.view_btn.grid_display');
const apartmentsTable = document.querySelector('.apartments-table');
const residence = document.querySelector('.residence');
const favCell = document.querySelector('.fav-cell');




gridViewButton.onclick = function () {
	apartmentsTable.classList.add('grid-view');
	apartmentsTable.classList.remove('dataTable');
	tableViewButton.classList.remove('active');
	gridViewButton.classList.add('active')

  };

tableViewButton.onclick = function () {
	apartmentsTable.classList.remove('grid-view');
	apartmentsTable.classList.add('dataTable');
	tableViewButton.classList.add('active');
	gridViewButton.classList.remove('active')


  };



// image transition on accordion change -- building-amenities page

if (window.location.pathname=='/building-amenities/') {
	const accordionHeaders = Array.from(document.querySelectorAll('.accordion.building-amenities .btn.btn-link'));
const imagesForAccordion = Array.from(document.querySelectorAll('.accordion-images ul li'));
imagesForAccordion ? imagesForAccordion[0].classList.add('active') : ''; // add active to first default item

   accordionHeaders.forEach((header,i) => header.addEventListener('click', () => {
	imagesForAccordion.forEach((image) => {
		image.classList.remove('active');
	} )

	imagesForAccordion[`${i}`].classList.add('active'); // add active class when clicking on button
	}
   ));

}




// contact form

if (window.location.pathname=='/contact/') {

window.onload = function() {
	// Hides spam trap

	document.getElementById("are_you_simulated").style.display = "none";

	// Hides Agent/Brokerage field at the start

	hideAgent();
  };

  var submitting = false;

  var agentYes = document.getElementById("agent_yes");
  var agentNo = document.getElementById("agent_no");

  var brokerYes = document.getElementById("broker_yes");
  var brokerNo  = document.getElementById("broker_no");

  function hideAgent () {
	if ( !agentYes.checked && !agentNo.checked) {
	document.getElementById("hidden-agent").style.display = "none";
	document.getElementById("hidden-broker").style.display = "none";
	document.getElementById("hidden-broker-question").style.display = "none";
  } else if (agentYes.checked)  {
	document.getElementById("hidden-agent").style.display = "block";
	document.getElementById("hidden-broker").style.display = "none";
	document.getElementById("hidden-broker-question").style.display = "none";
	document.getElementById("broker_yes").checked = false;
  }
	else  {
	  document.getElementById("hidden-broker").style.display = "none";
	  document.getElementById("hidden-agent").style.display = "none";
	}
  }

  function showBroker () {
	if ( agentNo.checked && !brokerYes.checked && !brokerNo.checked) {
	document.getElementById("hidden-agent").style.display = "none";
	document.getElementById("hidden-broker-question").style.display = "flex";
  } else if (brokerYes.checked)  {
	document.getElementById("hidden-broker").style.display = "block";
  }
	else  {
	  document.getElementById("hidden-broker").style.display = "none";
	  document.getElementById("hidden-broker-question").style.display = "flex";
	}
  }


	  document.getElementById("agent_yes").onchange = function() {
		hideAgent();
	  }
	  document.getElementById("agent_no").onchange = function() {
		hideAgent();
		showBroker();
	  }

	  document.getElementById("broker_yes").onchange = function() {
		showBroker();
	  }
	  document.getElementById("broker_no").onchange = function() {
		showBroker();
	  }





  function submitRegistrationForm(element) {

	// reset errors on submit
	document.getElementById("broker-label").classList.remove("error");
	document.getElementById("broker-label-2").classList.remove("error");
	document.getElementById("broker-label-3").classList.remove("error");
	document.getElementById("broker-label-4").classList.remove("error");
	document.getElementById("contact_first_name").classList.remove("error");
	document.getElementById("contact_last_name").classList.remove("error");
	document.getElementById("contact_email").classList.remove("error");
	document.getElementById("answers_5538").parentNode.classList.remove("error")

	var form = document.querySelector(
	  "body#spark-registration-form form, form#spark-registration-form"
	);

	var missing = "";

	var required = { contact_email: "Email" };

	var customRequired = document.querySelectorAll(
	  "input:required, textarea:required, select:required"
	);

	var questionsRequired = { answers_5538: "Referral source" };
	agentYes.checked && (questionsRequired["answers_5554"] = "Brokerage Firm");
	brokerYes.checked && ( questionsRequired["answers_5553"] = "Broker Company" );

	// Adds custom required inputs to the 'required' object

	for (var i = 0; i < customRequired.length; i++) {
	  required[customRequired[i].id] = customRequired[
		i
	  ].parentNode.firstElementChild.innerHTML.replace("*", "");
	}

	// Adds required question inputs to the 'required' object

	for (var key in questionsRequired) {
	  required[key] = questionsRequired[key];
	}

	// Iterates through required fields and adds any that have

	// not been populated to 'missing' list

	for (var key in required) {
	  var elements = Array.from(
		document.querySelectorAll("[id^='" + key + "']")
	  );

	  if (elements.length > 0) {
		var missing_field = true;

		elements.forEach(function(el) {
		  if (
			el.length < 1 ||
			(el &&
			  ((el.type == "checkbox" && el.checked) ||
				(el.type == "radio" && el.checked) ||
				(el.type != "radio" && el.type != "checkbox" && el.value) ||
				(document.getElementById(key + "_other_text") &&
				  document.getElementById(key + "_other_text").value)))
		  ) {
			missing_field = false;
		  }
		});

		if (missing_field) {
		  const valueOfRequired = required[key];
		  const keyOfRequired = Object.keys(required).find(key => required[key] === valueOfRequired);

	   let amISelect = document.getElementById(key).classList.contains('selectpicker');

			amISelect ?
			document.getElementById(keyOfRequired).parentNode.classList.add("error")
			:
			document.getElementById(keyOfRequired).classList.add("error");

		  missing += "- " + required[key] + "\r\n";
		}
	  }
	}

	// Tests email input value against RFC 5322 Official Standard Email Regex

	var email = document.getElementById("contact_email").value;

	if (
	  !/(?:[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*|"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/.test(
		email
	  )
	) {
	  document.getElementById("contact_email").classList.add("error");
	  missing += "- Email is invalid\r\n";
	}

	if (!agentYes.checked && !agentNo.checked ) {
	  missing += "- Are you a broker? ";
	  document.getElementById("broker-label").classList.add("error");
	  document.getElementById("broker-label-2").classList.add("error");
	}

	if (agentNo.checked && !broker_yes.checked && !broker_no.checked ) {
	  missing += "- Are you currently represented by a broker?";
	  document.getElementById("broker-label-3").classList.add("error");
	  document.getElementById("broker-label-4").classList.add("error");
	}

	if (missing != "" ) {
	  return false;
	}

	// Prevents duplicate submissions

	if (submitting) {
	  return false;
	}

	submitting = true;

	form.submit();
  }

}

//Share property

var shareProperty = function shareProperty() {
	var propertyNameFromUrl = encodeURIComponent(document.title);
	var splitpropertyNameFromUrl = propertyNameFromUrl.split("%7C");
	var propertyName = splitpropertyNameFromUrl[0];
	var propertyUrl = encodeURIComponent(document.URL);
	window.location.href = "mailto:?subject=Check out this property: " + propertyName + "&body=Hi,%0D%0A%0D%0AThis property is worth considering as part of our search:%20%0D%0A%0D%0AAddress: " + propertyName + "%20%0D%0A%0D%0AVisit: " + propertyUrl + "%20%0D%0A%0D%0ABest,";
  };
