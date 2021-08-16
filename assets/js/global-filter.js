/**
 *
 * @param {HTMLElement} element The <select> tag element
 */
 function parse_selector_id_from_element(element) {
    var data_id = element.getAttribute('name');
    var data_type = element.dataset.objectType || 'none';

    return data_type + '-' + data_id;
}

/**
 *
 * @param {HTMLELement} element
 * @returns
 */
function jankx_parse_choices_configurations(element) {
    return {};
}

function jankx_global_filter_init() {
    var filters = document.querySelectorAll('select.select-filter');
    if (filters.length > 0) {
        for (let filterIndex = 0; filterIndex < filters.length; filterIndex++) {
            const element = filters[filterIndex];
            window[parse_selector_id_from_element(element)] = new Choices(
                element,
                jankx_parse_choices_configurations(element)
            );
        }
    }
}

document.addEventListener(
    'DOMContentLoaded',
    jankx_global_filter_init
);