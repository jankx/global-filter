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

function jankx_global_filter_collapse_content() {
    var collapseButtons = document.querySelectorAll('.jankx-global-filter .collapse-button');
    if (collapseButtons.length > 0) {
        collapseButtons.forEach(function(btn){
            btn.addEventListener('click', function(e){
                e.preventDefault();

                var filter_wrapper = e.target.findParent('.jankx-filter');
                if (!filter_wrapper) {
                    return;
                }

                if (filter_wrapper.hasClass('collapse')) {
                    filter_wrapper.addClass('expand');
                    filter_wrapper.removeClass('collapse');
                } else {
                    filter_wrapper.addClass('collapse');
                    filter_wrapper.removeClass('expand');
                }
            });
        });
    }
}
/**
 * @param {Array} terms list terms of queried object
 * @param {string} data_type taxonomy name
 * @param {FormData} request_body
 * @return boolean
 */
function jankx_check_queried_object_with_request_body(terms, data_type, request_body) {
    const checkingKey = data_type + '[' + Object.keys(terms).join('') + '][]';
    request_body.forEach(function(value, key){
        if (key==checkingKey) {
            return true;
        }
    });
    return false;
}

/**
 *
 * @param {FormData} requestBody
 * @param {String} destLayout
 */
function jankx_global_filter_request_ajax(requestBody, destLayout) {
    var destLayoutDOM = document.getElementById(destLayout);

    var post_type = destLayoutDOM.dataset.postType;
    var current_page = destLayoutDOM.dataset.currentPage || 1;
    var posts_per_page = destLayoutDOM.dataset.postsPerPage || 10;
    var layout = destLayoutDOM.dataset.layout || 'card';
    var engine_id = destLayoutDOM.dataset.engineId;
    var thumb_pos = destLayoutDOM.dataset.thumbnailPosition;

    requestBody.append('post_type', post_type);
    requestBody.append('current_page', current_page);
    requestBody.append('posts_per_page', posts_per_page);
    requestBody.append('layout', layout);
    requestBody.append('engine_id', engine_id);
    requestBody.append('thumb_pos', thumb_pos);

    requestBody.append('action', jkx_global_filter.action);

    // Load current conditions
    if (Object.keys(jkx_global_filter.current_conditions).length > 0) {
        var current_conditions = jkx_global_filter.current_conditions;
        Object.keys(current_conditions).forEach(function(data_type) {
            var data_terms = current_conditions[data_type];
            if (Object.keys(data_terms).length > 0 && !jankx_check_queried_object_with_request_body(data_terms, data_type, requestBody)) {
                Object.keys(data_terms).forEach(function(type) {
                    if (Array.isArray(data_terms[type])) {
                        data_terms[type].forEach(function(term) {
                            requestBody.append(data_type+'['+ type +'][]', term);
                        })
                    }
                });
            }
        });
    }

    jankx_ajax(jkx_global_filter.ajax_url, 'GET', requestBody, {
        beforeSend: function(){
        },
        complete: function (xhr) {
            var jankx_post_wrap = destLayoutDOM.find('.jankx-posts');
            var mode = jankx_post_wrap.dataset.mode || 'append';

            if (xhr.readyState === 4 && xhr.status === 200) {
                var success_flag = xhr.responseJSON && xhr.responseJSON.success;

                // Success case
                if (success_flag) {
                    var realContentWrap = jankx_post_wrap.dataset.contentWrapper
                        ? jankx_post_wrap.find(jankx_post_wrap.dataset.contentWrapper)
                        : jankx_post_wrap;

                    if (mode === 'replace') {
                        realContentWrap.html(xhr.responseJSON.data.content);
                    } else {
                        realContentWrap.appendHTML(xhr.responseJSON.data.content);
                    }

                    if (['carousel', 'preset-3', 'preset-5'].indexOf(layout) >= 0) {
                        var carouselWrap = destLayoutDOM.find('.splide');
                        var carouselId = carouselWrap.getAttribute('id').replaceAll(/-/ig, '_');
                        if (window[carouselId]) {
                            window[carouselId].destroy();
                        }
                        configs = window[carouselId + '__configs'] || {};
                        window[carouselId] = new Splide(carouselWrap, configs);
                        window[carouselId].mount();
                    }
                }

                // Support callback
                var jankx_callback = jkx_post_layout['jankx_tabs_' + engine_id + '_' + layout  + '_' + post_type];
                if (window[jankx_callback]) {
                    window[jankx_callback](realContentWrap, body, success_flag);
                }
            }
        }
    });
}

/**
 *
 * @param {Event} e
 */
function jankx_global_filter_control_change_value(e, destLayout = undefined) {
    if (destLayout === undefined) {
        var currentFilter = e.target.findParent('.jankx-global-filter');
        var destLayout = currentFilter.dataset.destLayout || 'jankx-main-layout';
    }
    // get filter values
    var filtersOfDestLayouts = document.querySelectorAll('[data-dest-layout=' + destLayout + ']');
    var filterValues = new FormData();
    filtersOfDestLayouts.forEach(function(filter){
        const formOffilter = filter.querySelector('form');
        if (formOffilter) {
            var data = new FormData(formOffilter);
            for (var [key, val] of data) {
                filterValues.append(key, val);
            }
        }
    });


    if (destLayout === 'jankx-main-layout') {
        var orderingFilter = document.querySelector('.jankx-product-ordering select.orderby');
        if (orderingFilter) {
            filterValues.append('order_product', orderingFilter.value);
        }
    }
    jankx_global_filter_request_ajax(filterValues, destLayout);
}

function jankx_global_filter_monitor_filters()
{
    var filterControls = document.querySelectorAll('.jankx-filter .filter-control');
    if (filterControls.length > 0) {
        filterControls.forEach(function(filterControl) {
            filterControl.addEventListener('change', jankx_global_filter_control_change_value);
        });
    }

    // Support product order by
    var orderByControl = document.querySelector('.jankx-product-ordering select.orderby');
    if (orderByControl) {
        orderByControl.addEventListener("change", function(e) {
            jankx_global_filter_control_change_value(e, 'jankx-main-layout');
        });
    }
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

    jankx_global_filter_collapse_content();
    jankx_global_filter_monitor_filters();
}

document.addEventListener(
    'DOMContentLoaded',
    jankx_global_filter_init
);
