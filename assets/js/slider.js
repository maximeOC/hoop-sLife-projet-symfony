import noUiSlider from 'nouislider';
import 'nouislider/dist/nouislider.css';
const slider = document.getElementById('price-slider');
if(slider){
    const min = document.getElementById('min');
    const max = document.getElementById('max');
    const range = noUiSlider.create(slider, {
        start: [min.value || 0, max.value || 300],
        connect: true,
        step: 10,
        range: {
            'min': 0,
            'max': 300
        }
    })


    range.on('slide', function (values, handle ){
        if (handle === 0 ){
            min.value = Math.round(values[0])
        }
        if (handle === 1 ){
            max.value = Math.round(values[1])
        }
        console.log(values, handle)
    })
}


