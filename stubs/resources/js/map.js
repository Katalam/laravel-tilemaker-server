import { Map, NavigationControl } from 'maplibre-gl';
import 'maplibre-gl/dist/maplibre-gl.css'

export var map;

export async function fetchMetaData() {
    fetch('/tiles/meta-data')
        .then(response => response.json())
        .then(data => {
            const styleUrl = import.meta.env.VITE_APP_URL + '/storage/style.json'
            const bounds = data.bounds.split(',').map(parseFloat)
            map = new Map({
                container: 'map',
                style: styleUrl,
                center: [
                    (bounds[0] + bounds[2]) / 2,
                    (bounds[1] + bounds[3]) / 2
                ],
                zoom: 10,
            });

            map.addControl(new NavigationControl());
        });
}

export function parseDirectionsGeometry(data) {
    const coordinates = [];

    for (let i = 0; i < data.shapes.length; i++) {
        coordinates.push(...decode(data.shapes[i], 6))
    }

    return coordinates
}

export function decode(str, precision) {
    let index = 0
    let lat = 0
    let lng = 0
    const coordinates = []
    let shift = 0
    let result = 0
    let byte = null
    let latitude_change
    let longitude_change

    const factor = Math.pow(10, precision || 6)

    // Coordinates have variable length when encoded, so just keep
    // track of whether we've hit the end of the string. In each
    // loop iteration, a single coordinate is decoded.
    while (index < str.length) {
        // Reset shift, result, and byte
        byte = null
        shift = 0
        result = 0

        do {
            byte = str.charCodeAt(index++) - 63
            result |= (byte & 0x1f) << shift
            shift += 5
        } while (byte >= 0x20)

        latitude_change = result & 1 ? ~(result >> 1) : result >> 1

        shift = result = 0

        do {
            byte = str.charCodeAt(index++) - 63
            result |= (byte & 0x1f) << shift
            shift += 5
        } while (byte >= 0x20)

        longitude_change = result & 1 ? ~(result >> 1) : result >> 1

        lat += latitude_change
        lng += longitude_change

        coordinates.push([lat / factor, lng / factor])
    }

    return coordinates
}
