import { Map as MapLibre, NavigationControl } from 'maplibre-gl';
import 'maplibre-gl/dist/maplibre-gl.css'

export class Map {
    static styleUrl = import.meta.env.VITE_APP_URL + '/storage/style.json'
    static metaDataUrl = '/tiles/meta-data'
    static routeUrl = '/route'

    value;

    constructor() {
    }

    async init() {
        return this.fetchMetaData()
    }

    async fetchMetaData() {
        fetch(Map.metaDataUrl)
            .then(response => response.json())
            .then(data => {
                const bounds = data.bounds.split(',').map(parseFloat)
                this.value = new MapLibre({
                    container: 'map',
                    style: Map.styleUrl,
                    center: [
                        (bounds[0] + bounds[2]) / 2,
                        (bounds[1] + bounds[3]) / 2
                    ],
                    zoom: 10,
                });

                this.value.addControl(new NavigationControl());
            });
    }

    async getRoute() {
        return fetch(Map.routeUrl)
            .then(response => response.json());
    }

    /**
     * @param {Object} route
     * @param {array} route.shapes
     * @returns {void}
     */
    displayRoute(route) {
        const coordinates = this.parseDirectionsGeometry(route)
            .map((coordinates) => {
                return [coordinates[1], coordinates[0]]
            });

        this.value.addSource('route', {
            'type': 'geojson',
            'data': {
                'type': 'Feature',
                'properties': {},
                'geometry': {
                    'type': 'LineString',
                    'coordinates': coordinates,
                }
            }
        })
        this.value.addLayer({
            'id': 'route',
            'type': 'line',
            'source': 'route',
            'layout': {
                'line-cap': 'round',
                'line-join': 'round'
            },
            'paint': {
                'line-color': '#ed6498',
                'line-width': 5,
                'line-opacity': 0.8
            }
        });
    }

    /**
     * @param {Object} data
     * @param {array} data.shapes
     * @returns {number[][]}
     */
    parseDirectionsGeometry(data) {
        const coordinates = [];

        for (let i = 0; i < data.shapes.length; i++) {
            coordinates.push(...this.decode(data.shapes[i], 6))
        }

        return coordinates
    }

    /**
     * @param {string} str
     * @param {number} precision
     * @returns {*[]}
     */
    decode(str, precision) {
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
}
