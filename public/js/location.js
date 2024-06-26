async function callApiWithObject(endPoint, object) {
	const parser = (r) => ({
		id: r.address.street.id,
		street: r.address.street.name,
		number: r.address.number,
		postCode: r.address.street.postCode,
		municipality: r.address.street.municipality,
		coordonates: r.point,
		adNc: r.adNc,
	});

	const url = `https://geoservices.irisnet.be/localization/Rest/Localize/${endPoint}?json=`;
	const request = url + encodeURIComponent(JSON.stringify(object));
	const response = await fetch(request);
	const result = await response.json();

	console.log(result.result);
	if (Array.isArray(result.result)) {
		return result.result.map((r) => parser(r));
	} else {
		return [parser(result.result)];
	}
}

export async function getAddressesFromText(text, language = "fr") {
	const object = {
		language,
		address: text,
		spatialReference: 4326,
	};
	return await callApiWithObject("getaddresses", object);
}

export async function getAddresseFromParts(
	{ street, number, postcode, municipality },
	language = "fr"
) {
	console.log("get parts ************");
	const object = {
		language,
		address: {
			street: {
				name: street,
				postcode,
				municipality,
			},
			number,
		},
		spatialReference: 4326,
	};
	return await callApiWithObject("getaddressesfields", object);
}

export async function getAddressFromLocation(location, language = "fr") {
	//Créer une condition pour alterner d'un fournisseur à l'autre selon disponibilité
	const { x, y } = locationToPoint(location);
	const object = {
		language,
		point: { x, y },
		SRS_In: "102100",
		SRS_Out: "102100",
	};
	return await callApiWithObject("getaddressfromxy", object);

	// const parser = (address) => ({
	// 	street: address.road,
	// 	number: address.house_number,
	// 	postCode: address.postCode,
	// 	municipality: address.town,
	// 	coordonates: { x, y },
	// });
	// const url = `https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${y}&lon=${x}`;
	// const response = await fetch(url);
	// const result = await response.json();
	// return parser(result.address);
}

const Wgs84EquatorialRadius = 6378137;
const Wgs84MetersPerDegree = (Wgs84EquatorialRadius * Math.PI) / 180;

function locationToPoint({ longitude, latitude }) {
	return {
		x: Wgs84MetersPerDegree * longitude,
		y: Wgs84MetersPerDegree * latitudeToY(latitude),
	};
}

function pointToLocation({ x, y }) {
	return {
		lat: yToLatitude(y) / Wgs84MetersPerDegree,
		lon: x / Wgs84MetersPerDegree,
	};
}

function yToLatitude(y) {
	return 90 - (Math.atan(Math.exp((-y * Math.PI) / 180)) * 360) / Math.PI;
}

function latitudeToY(lat) {
	if (lat <= -90) {
		return Number.NEGATIVE_INFINITY;
	}

	if (lat >= 90) {
		return Number.POSITIVE_INFINITY;
	}

	return (Math.log(Math.tan(((lat + 90) * Math.PI) / 360)) * 180) / Math.PI;
}
