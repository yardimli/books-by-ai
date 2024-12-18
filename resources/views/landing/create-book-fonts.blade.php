@push('google-fonts')
	<link href="https://fonts.googleapis.com/css2?family=Birthstone&family=Bungee+Tint&family=Cabin:ital,wght@0,400..700;1,400..700&family=Charis+SIL:ital,wght@0,400;0,700;1,400;1,700&family=EB+Garamond:ital,wght@0,400..800;1,400..800&family=Goudy+Bookletter+1911&family=Instrument+Serif:ital@0;1&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Oswald:wght@200..700&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Source+Serif+4:ital,opsz,wght@0,8..60,200..900;1,8..60,200..900&family=Young+Serif&display=swap" rel="stylesheet">
@endpush

<style>
    .charis-sil-regular {
        font-family: "Charis SIL", serif;
        font-weight: 400;
        font-style: normal;
    }

    .charis-sil-bold {
        font-family: "Charis SIL", serif;
        font-weight: 700;
        font-style: normal;
    }

    .charis-sil-regular-italic {
        font-family: "Charis SIL", serif;
        font-weight: 400;
        font-style: italic;
    }

    .charis-sil-bold-italic {
        font-family: "Charis SIL", serif;
        font-weight: 700;
        font-style: italic;
    }


    .instrument-serif-regular {
        font-family: "Instrument Serif", serif;
        font-weight: 400;
        font-style: normal;
    }

    .instrument-serif-regular-italic {
        font-family: "Instrument Serif", serif;
        font-weight: 400;
        font-style: italic;
    }


    .young-serif-regular {
        font-family: "Young Serif", serif;
        font-weight: 400;
        font-style: normal;
    }

    .goudy-bookletter-1911-regular {
        font-family: "Goudy Bookletter 1911", serif;
        font-weight: 400;
        font-style: normal;
    }


    .birthstone-regular {
        font-family: "Birthstone", cursive;
        font-weight: 400;
        font-style: normal;
    }


    .oswald-light {
        font-family: "Oswald", sans-serif;
        font-optical-sizing: auto;
        font-weight: 300;
        font-style: normal;
    }

    .oswald-regular {
        font-family: "Oswald", sans-serif;
        font-optical-sizing: auto;
        font-weight: 400;
        font-style: normal;
    }

    .oswald-semibold {
        font-family: "Oswald", sans-serif;
        font-optical-sizing: auto;
        font-weight: 600;
        font-style: normal;
    }

    .oswald-bold {
        font-family: "Oswald", sans-serif;
        font-optical-sizing: auto;
        font-weight: 700;
        font-style: normal;
    }


    .cabin-regular {
        font-family: "Cabin", sans-serif;
        font-optical-sizing: auto;
        font-weight: 400;
        font-style: normal;
        font-variation-settings: "wdth" 100;
    }

    .cabin-medium {
        font-family: "Cabin", sans-serif;
        font-optical-sizing: auto;
        font-weight: 500;
        font-style: normal;
        font-variation-settings: "wdth" 100;
    }

    .cabin-bold {
        font-family: "Cabin", sans-serif;
        font-optical-sizing: auto;
        font-weight: 700;
        font-style: normal;
        font-variation-settings: "wdth" 100;
    }

    .source-serif-4-regular {
        font-family: "Source Serif 4", serif;
        font-optical-sizing: auto;
        font-weight: 400;
        font-style: normal;
    }

    .source-serif-4-bold {
        font-family: "Source Serif 4", serif;
        font-optical-sizing: auto;
        font-weight: 600;
        font-style: normal;
    }

    .roboto-thin {
        font-family: "Roboto", sans-serif;
        font-weight: 100;
        font-style: normal;
    }

    .roboto-light {
        font-family: "Roboto", sans-serif;
        font-weight: 300;
        font-style: normal;
    }

    .roboto-regular {
        font-family: "Roboto", sans-serif;
        font-weight: 400;
        font-style: normal;
    }

    .roboto-medium {
        font-family: "Roboto", sans-serif;
        font-weight: 500;
        font-style: normal;
    }

    .roboto-bold {
        font-family: "Roboto", sans-serif;
        font-weight: 700;
        font-style: normal;
    }

    .roboto-black {
        font-family: "Roboto", sans-serif;
        font-weight: 900;
        font-style: normal;
    }

    .roboto-thin-italic {
        font-family: "Roboto", sans-serif;
        font-weight: 100;
        font-style: italic;
    }

    .roboto-light-italic {
        font-family: "Roboto", sans-serif;
        font-weight: 300;
        font-style: italic;
    }

    .roboto-regular-italic {
        font-family: "Roboto", sans-serif;
        font-weight: 400;
        font-style: italic;
    }

    .roboto-medium-italic {
        font-family: "Roboto", sans-serif;
        font-weight: 500;
        font-style: italic;
    }

    .roboto-bold-italic {
        font-family: "Roboto", sans-serif;
        font-weight: 700;
        font-style: italic;
    }

    .roboto-black-italic {
        font-family: "Roboto", sans-serif;
        font-weight: 900;
        font-style: italic;
    }

    .roboto-mono-regular {
        font-family: "Roboto Mono", monospace;
        font-optical-sizing: auto;
        font-weight: 400;
        font-style: normal;
    }

    .roboto-mono-bold {
        font-family: "Roboto Mono", monospace;
        font-optical-sizing: auto;
        font-weight: 600;
        font-style: normal;
    }


    .eb-garamond-regular {
        font-family: "EB Garamond", serif;
        font-optical-sizing: auto;
        font-weight: 400;
        font-style: normal;
    }

    .eb-garamond-bold {
        font-family: "EB Garamond", serif;
        font-optical-sizing: auto;
        font-weight: 600;
        font-style: normal;
    }

    .lato-thin {
        font-family: "Lato", serif;
        font-weight: 100;
        font-style: normal;
    }

    .lato-light {
        font-family: "Lato", serif;
        font-weight: 300;
        font-style: normal;
    }

    .lato-regular {
        font-family: "Lato", serif;
        font-weight: 400;
        font-style: normal;
    }

    .lato-bold {
        font-family: "Lato", serif;
        font-weight: 700;
        font-style: normal;
    }

    .lato-black {
        font-family: "Lato", serif;
        font-weight: 900;
        font-style: normal;
    }

    .lato-thin-italic {
        font-family: "Lato", serif;
        font-weight: 100;
        font-style: italic;
    }

    .lato-light-italic {
        font-family: "Lato", serif;
        font-weight: 300;
        font-style: italic;
    }

    .lato-regular-italic {
        font-family: "Lato", serif;
        font-weight: 400;
        font-style: italic;
    }

    .lato-bold-italic {
        font-family: "Lato", serif;
        font-weight: 700;
        font-style: italic;
    }

    .lato-black-italic {
        font-family: "Lato", serif;
        font-weight: 900;
        font-style: italic;
    }



    .bungee-tint-regular {
        font-family: 'Bungee Tint', sans-serif;
        font-weight: 400;
        font-style: normal;

        filter: hue-rotate(150deg) saturate(300%) brightness(130%);

        /*background: yellow;*/
        /*-webkit-background-clip: text;*/
        /*-webkit-text-fill-color: transparent;*/
    }

    .serif-font {
        font-family: Georgia, Times, "Times New Roman", serif;
    }
