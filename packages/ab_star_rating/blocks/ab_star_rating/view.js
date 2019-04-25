/**
 * Star Rating package for Concrete5
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 * 
 * @author Alex Borisov <linuxoidoz@gmail.com>
 * @copyright 2017-2018, Alex Borisov
 * @package Concrete\Package\ab_star_rating
 */

$(function(){
    $.each($('.ab-rating-stars'), function(index, element){
        var attr_data = $(element).attr('data-rating');
        var buid = $(element).attr('data-buid');
        js_data = $.parseJSON(attr_data);
    
        $(element).stars({
            stars: 5,
            color: js_data.color,
            value: js_data.value,
            text: js_data.show_star_text ? [js_data.star1_text, js_data.star2_text, js_data.star3_text, js_data.star4_text, js_data.star5_text] : [],
            click: function(n) {
                js_data.registered ? save(buid, n) : error(buid);
            }
        });
        
        $(element).find('i').css({'font-size': js_data.size + 'em'});
        
        if (js_data.show_star_text) {
            $(element).find('.rating-text').css({'height': '30px'});
        }
    });
    
    function save(buid, n) {
        var errors = $('#rating_errors_' + buid);
        errors.empty();
        
        var success = $('#rating_success_' + buid);
        
        var spinner_img = $('#rating_spinner_img_' + buid);
        spinner_img.removeClass('hidden');
        
        var error_list = $('<ul></ul>');
        
        var url = $('#rate_form_' + buid).attr('action');
        
        $.ajax({
            dataType: "json",
            type: "post",
            data: {
                'buid': buid,
                'n': n,
            },
            url: url,
        })
        .done(function(response) {console.log(response['bid']);
            error_list.empty();
            spinner_img.addClass('hidden');
                if (response['status'] === 'ok') {
                    errors.addClass('hidden');
                    success.removeClass('hidden');
                    setTimeout(function() {
                        window.location.reload(true);
                    }, 3000);
                }
                else {
                    success.addClass('hidden');
                    errors.removeClass('hidden');
                    errors.append('<p>' + js_data.errors + '</p>');
                    errors.append(error_list);
                    $.each(response['errors'], function(i, v){
                        error_list.append('<li>' + v + '</li>');
                    });
                    setTimeout(function() {
                        errors.addClass('hidden');
                        errors.empty();
                    }, 5000);
                }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            spinner_img.addClass('hidden');
            success.addClass('hidden');
            errors.removeClass('hidden');
            errors.append('<p>' + js_data.errors + '</p>');
            errors.append('<p>' + errorThrown + '</p>');
        });
    }
    
    function error(buid) {
        var errors = $('#rating_errors_' + buid);
        errors.empty();
        errors.removeClass('hidden');
        errors.append(js_data.error_register);
        setTimeout(function() {
            errors.addClass('hidden');
            errors.empty();
        }, 5000);
    }
});
