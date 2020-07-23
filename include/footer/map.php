<?php
$COORDS = \COption::GetOptionString( "askaron.settings", "UF_FOOTER_MAP");
if ($COORDS) {
    $COORDS = explode(',', $COORDS);
    if (count($COORDS) == 2) {
        $LAT = $COORDS[0];
        $LNG = $COORDS[1];
    }
}
?>
<?php if (isset($LAT) && isset($LNG) && $LAT && $LNG) :?>
    <div id="map"></div>
    <script>
        // функция гугл карты
        function initMap() {
            var odessa = {lat: <?=$LAT?>, lng: <?=$LNG?>};
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 15,
                center: odessa,
                styles: [
                    {
                        "featureType": "road",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "lightness": 100
                            },
                            {
                                "visibility": "simplified"
                            }
                        ]
                    },
                    {
                        "featureType": "water",
                        "elementType": "geometry",
                        "stylers": [
                            {
                                "visibility": "on"
                            },
                            {
                                "color": "#C6E2FF"
                            }
                        ]
                    },
                    {
                        "featureType": "poi",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#C5E3BF"
                            }
                        ]
                    },
                    {
                        "featureType": "road",
                        "elementType": "geometry.fill",
                        "stylers": [
                            {
                                "color": "#D1D1B8"
                            }
                        ]
                    }
                ]

            });
            var marker = new google.maps.Marker({
                position: odessa,
                map: map,
                icon: '<?=SITE_TEMPLATE_PATH?>/img/marker.svg'
            });
        }
    </script>
<?php endif; ?>

