// coucou veille branche
import {
	getAddressesFromText,
	getAddressFromLocation,
	getAddresseFromParts,
} from "./location.js";
/**import sheet from "./input-address.css" assert { type: "css" };**/
/**
 *  Les appels à l'API de geolocalisation doivent être externalisés du composant
 *
 * getAddressesFromText
 * Renvoit un ensemble adresses corresponadant à une saisie partielle
 *
 * getAddressFromLocation
 * Renvoit une adresse à partir d'une coordonnée
 *
 */
const CSS =
	`:host {
	position: relative;
	display: inline-block;
}

#select-id {
	display: none;
	cursor: pointer;
	position: absolute;
	width: 100%;
	padding: 5px 0;
	margin: 2px 0 0;
	font-size: 14px;
	background-color: #fff;
	border: 1px solid #ccc;
	border: 1px solid rgba(0, 0, 0, 0.15);
	border-radius: 4px;
	-webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
	box-shadow: 0 6px 12px rgba(0, 0, 0, 0.175);
}
.option {
	padding: 3px 20px;
	font-weight: 400;
	color: #333;
}
.option:hover {
	background-color: #801337;
	color: white;
}
.option > span {
	font-style: italic;
	font-weight: 500;
	color: #939292;
	font-size: 12px;
	white-space: nowrap;
}
.address {
	display: flex;
}
.street {
	flex-grow: 1;
}
button {
	width: 32px;
	font-weight: 900;
}

.loader {
	display: none;
	cursor: pointer;
	position: absolute;
	top: 0;
	width: 100%;
	height: 100%;
	background-color: aquamarine;
	justify-content: center;
}
.spiner {
	height: calc(100% - 4px);
	margin-top: 2px;
	aspect-ratio: 1;
	border: 5px solid #fff;
	border-bottom-color: transparent;
	border-radius: 50%;
	display: inline-block;
	box-sizing: border-box;
	animation: rotation 1s linear infinite;
}

@keyframes rotation {
	0% {
		transform: rotate(0deg);
	}
	100% {
		transform: rotate(360deg);
	}
}

`
const HTML = `
	<style>${CSS}</style>
    <div class="address">
			<div class="street">
					<slot></slot>
					<div class="loader">
						<span class="spiner"></span>
					</div>
			</div>
			<button id='action-id'></button>
    </div>
    <div id="select-id" tabindex="0">
        <div class="option"></div>
        <div class="option"></div>
        <div class="option"></div>
        <div class="option"></div>
        <div class="option"></div>
        <div class="option"></div>
        <div class="option"></div>
        <div class="option"></div>
        <div class="option"></div>
        <div class="option"></div>
        <div class="option"></div>
        <div class="option"></div>
    </div>
		`;

class InputAddress extends HTMLElement {
	constructor() {
		super();
		const shadow = this.attachShadow({ mode: "open" });
		//shadow.adoptedStyleSheets = [sheet];
		shadow.innerHTML = HTML;
	}

	connectedCallback() {
		this.elementSelect = this.shadowRoot.getElementById("select-id");
		this.elementOptions = this.shadowRoot.querySelectorAll(".option");
		this.buttonAction = this.shadowRoot.getElementById("action-id");
		this.elementInput = this.querySelector("#adresse-id");
		this.elementNumber = document.querySelector('[data-address="number"]');
		this.elementPostCode = document.querySelector('[data-address="post-code"]');
		this.elementAdnc = document.querySelector('[data-address="adnc"]');
		this.elementMunicipality = document.querySelector(
			'[data-address="municipality"]'
		);

		this.elementInput.addEventListener("keyup", (e) => {
			if (e.key === "Escape") {
				this.resetAddress();
				this.hideSelect();
				return;
			} else {
				this.work(this.elementInput.value);
			}
		});

		this.elementInput.addEventListener("blur", (e) => {
			if (e.relatedTarget !== this) {
				this.elementInput.value = "";
				this.hideSelect();
			}
		});

		this.elementSelect.addEventListener("click", (e) => {
			this.updateAdress(e.target.address || e.target.parentNode.address);
			this.hideSelect();
		});

		this.buttonAction.addEventListener("click", (e) => {
			if (e.target.innerText == "X") {
				this.resetAddress();
			} else {
				this.makeGeoPosition();
			}
		});

		this.elementNumber.addEventListener("keydown", (e) => {
			e.target.style.background = "";
			e.target.classList.remove('error');
		}
		)

		this.elementNumber.addEventListener("change", () =>
			this.validationAdress()
		);

		this.resetAddress();
	}

	resetAddress() {
		this.buttonAction.innerText = "V";
		this.elementInput.disabled = false;
		this.elementInput.value = "";
		this.elementNumber.value = "";
		this.elementPostCode.value = "";
		this.elementMunicipality.value = "";
		this.elementPostCode.disabled = false;
		this.elementMunicipality.disabled = false;
		this.elementAdnc.value = "";
		this.elementInput.focus();
	}
	updateAdress(address) {
		this.buttonAction.innerText = "X";
		this.elementInput.disabled = true;
		this.elementInput.value = address.street ?? "";
		this.elementNumber.value = address.number ?? "";
		this.elementPostCode.value = address.postCode ?? "";
		this.elementMunicipality.value = address.municipality ?? "";
		this.elementAdnc.value = address.adNc ?? "";
		this.elementPostCode.disabled = true;
		this.elementMunicipality.disabled = true;
		if (this.elementNumber.value === "") this.elementNumber.focus();
	}

	showSelect() {
		this.elementSelect.style.display = "block";
	}

	hideSelect() {
		this.elementSelect.style = "";
	}

	showLoader() {
		this.shadowRoot.querySelector(".loader").style.display = "flex";
	}
	hideLoader() {
		this.shadowRoot.querySelector(".loader").style = "";
	}

	async work(search) {
		search = search.trim();
		if (search.length > 2) {
			const addresses = await getAddressesFromText(search);

			if (addresses.error === true) {
				console.log("error API", addresses);
			} else {
				this.setListAddresses(addresses, search);
			}
		}
	}

	async validationAdress() {
		const adress = {
			street: this.elementInput.value,
			number: this.elementNumber.value,
			postcode: this.elementPostCode.value,
			municipality: this.elementMunicipality.value,
		};
		const result = await getAddresseFromParts(adress);
		console.log(result);
		if (result && result[0]) {
			if (result[0].adNc) {
				this.elementPostCode.value = result[0].postCode;
				this.elementMunicipality.value = result[0].municipality;
				this.elementAdnc.value = result[0].adNc
			} else {
				this.elementNumber.focus()
				this.elementNumber.select()
				this.elementNumber.style.background = "red";
				this.elementNumber.classList.add('error');
			}
		}
	}

	/**
	 * setListAddresses(addresses, search)
	 *
	 * génère les éléments de la liste d'adresse
	 *  - avec la mise en évidence des termes de la recherche
	 *  - avec les données de l'adresse (dataset)
	 *
	 * @param {[{street, number, postCode, municipality}]} addresses
	 * @param {string} search
	 *
	 */
	setListAddresses(addresses, search) {
		const formateAddress = ({ street, number, postCode, municipality }) => {
			let result = `${street} ${number !== "" ? " " + number + ", " : ""}`;

			if (search && typeof search == "string") {
				search.replace(/ +/g, " ");
				const searchs = search.split(" ");
				searchs.forEach((s) => {
					result = result.replace(new RegExp(s, "i"), (m) => `<%%>${m}</%%>`);
				});
				result = result.replaceAll("%%", "strong");
			}
			result += `<span>${postCode} ${municipality}</span>`;
			return `${result}`;
		};

		if (addresses) {
			this.showSelect();
			const options = this.elementOptions;
			for (let i = 0; i < addresses.length; i++) {
				if (i < options.length) {
					options[i].innerHTML = formateAddress(addresses[i]);
					options[i].address = { ...addresses[i] };
					options[i].style.display = "bloc";
				} else {
					console.log("excessive response from API", i, addresses[i]);
				}
			}
			// cache les options vides
			for (let i = addresses.length; i < options.length; i++) {
				options[i].style.display = "none";
			}
		}
	}

	async makeGeoPosition() {
		const onSuccess = async (pos) => {
			const address = await getAddressFromLocation(pos.coords);
			if (address && address[0]) {
				this.updateAdress(address[0]);
			}
			this.hideLoader();
		};

		const onError = (error) => {
			console.log(error);
			this.hideLoader();
		};
		const options = {
			enableHighAccuracy: true,
			timeout: 15000,
			maximumAge: 0,
		};

		if ("geolocation" in navigator) {
			/* geolocation is available */
			this.showLoader();
			navigator.geolocation.getCurrentPosition(onSuccess, onError, options);
		} else {
			/* geolocation IS NOT available */
		}
	}
}

customElements.define("input-address", InputAddress);