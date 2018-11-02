var $sayButton = $('.message-submit');
var chatterbotUrl = 'https://django-test-jayapraveen.cs50.io/chatterbot/';


var $messages = $('.messages-content'),
    d, h, m,
    i = 0;

$(window).load(function() {
  $messages.mCustomScrollbar();
  setTimeout(function() {
    fakeMessage();
    fakeMessage();
  }, 100);
});


function updateScrollbar() {
  $messages.mCustomScrollbar("update").mCustomScrollbar('scrollTo', 'bottom', {
    scrollInertia: 10,
    timeout: 0
  });
}

function setDate(){
  d = new Date()
  if (m != d.getMinutes()) {
    m = d.getMinutes();
    $('<div class="timestamp">' + d.getHours() + ':' + m + '</div>').appendTo($('.message:last'));
    $('<div class="checkmark-sent-delivered">&check;</div>').appendTo($('.message:last'));
    $('<div class="checkmark-read">&check;</div>').appendTo($('.message:last'));
  }
}

function insertMessage() {
  msg = $('.message-input').val();
  console.log(msg)
  if ($.trim(msg) == '') {
    return false;
  }
  $('<div class="message message-personal">' + msg + '</div>').appendTo($('.mCSB_container')).addClass('new');
  setDate();
  $('.message-input').val(null);
  updateScrollbar();
  setTimeout(function() {
    messenger();
  }, 1000 + (Math.random() * 20) * 100);
}

$('.message-submit').click(function() {
  insertMessage();
});

$(window).on('keydown', function(e) {
  if (e.which == 13) {
    insertMessage();
    return false;
  }
});

var Fake = [
  'Hi, I\'m RIBA',
  'Nice to meet you'
]

function fakeMessage() {
 
  $('<div class="message loading new"><figure class="avatar"><img src="https://s3.amazonaws.com/gonativeio/images_generated/1541166129565_0a5d4wt7f4xv4_540x540.9.png" /></figure><span></span></div>').appendTo($('.mCSB_container'));
  updateScrollbar();

  setTimeout(function() {
    $('.message.loading').remove();
    $('<div class="message new"><figure class="avatar"><img src="https://s3.amazonaws.com/gonativeio/images_generated/1541166129565_0a5d4wt7f4xv4_540x540.9.png" /></figure>' + Fake[i] + '</div>').appendTo($('.mCSB_container')).addClass('new');
    setDate();
    updateScrollbar();
    i++;
  }, 1000 + (Math.random() * 20) * 100);

}

function messenger() {
  
  var inputData = {
          'text': msg
        }
  
        var $submit = $.ajax({
          type: 'POST',
          url: chatterbotUrl,
          data: JSON.stringify(inputData),
          contentType: 'application/json'
        });

            
    if ($('.message-input').val() != '') {
    return false;
  }
  
  $submit.done(function(statement) {
  $('<div class="message loading new"><figure class="avatar"><img src="https://s3.amazonaws.com/gonativeio/images_generated/1541166129565_0a5d4wt7f4xv4_540x540.9.png" /></figure><span></span></div>').appendTo($('.mCSB_container'));
  updateScrollbar();

  setTimeout(function() {
    $('.message.loading').remove();
    $('<div class="message new"><figure class="avatar"><img src="https://s3.amazonaws.com/gonativeio/images_generated/1541166129565_0a5d4wt7f4xv4_540x540.9.png" /></figure>' + statement.text + '</div>').appendTo($('.mCSB_container')).addClass('new');
    setDate();
    updateScrollbar();
    i++;
  }, 1000 + (Math.random() * 20) * 100);
});

}
var csrftoken = Cookies.get('csrftoken');
function csrfSafeMethod(method) {
        // these HTTP methods do not require CSRF protection
        return (/^(GET|HEAD|OPTIONS|TRACE)$/.test(method));
      }

      $.ajaxSetup({
        beforeSend: function(xhr, settings) {
          if (!csrfSafeMethod(settings.type) && !this.crossDomain) {
            xhr.setRequestHeader("X-CSRFToken", csrftoken);
          }
        }
      });



$('.button').click(function(){
  $('.menu .items span').toggleClass('active');
   $('.menu .button').toggleClass('active');
});
