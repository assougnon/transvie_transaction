const notificationsWrapper = $('.dropdown-notifications');
const notificationsToggle = notificationsWrapper.find('a[data-bs-toggle]');
const notificationsCountElem = notificationsToggle.find('span[data-count]');
 let notificationsCount     = parseInt(notificationsCountElem.data('count'));
 const notifications = notificationsWrapper.find('ul.list-group-flush');



/* if (notificationsCount <= 0) {
   notificationsWrapper.hide();
 }*/


Echo.channel('transaction-created')
  .listen('.transaction.created', (event) => {

    var existingNotifications = notifications.html();
    var newNotificationHtml = `
          <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                          <img src=" ${assetsPath}img/avatars/1.png" alt class="h-auto rounded-circle">
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-1">Nouvel Transaction ${event.transaction.numero}</h6>
                        <p class="mb-0">${event.message}</p>
                        <small class="text-muted">1h ago</small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="ti ti-x"></span></a>
                      </div>
                    </div>
                  </li>
        `;
    notifications.html(newNotificationHtml + existingNotifications);

    notificationsCount += 1;
    notificationsCountElem.attr('data-count', notificationsCount);
    notificationsCountElem.text(notificationsCount);

    notificationsWrapper.show();
  });


/*
const notificationsWrapper = $('.dropdown-notifications');
const notificationsToggle = notificationsWrapper.find('a[data-bs-toggle]');
const notificationsCountElem = notificationsToggle.find('span[data-count]');
let notificationsCount     = parseInt(notificationsCountElem.data('count'));
const notifications = notificationsWrapper.find('ul.list-group-flush');

let pusher = new Pusher('f6f69cb8e6be77d95ebf', {
  cluster:'eu',
  encrypted: true
});

// Subscribe to the channel we specified in our Laravel Event
let channel = pusher.subscribe('transaction-created');

// Bind a function to a Event (the full Laravel class)
channel.bind('App\\Events\\TransactionCreated', function(data) {
  console.log(data);
  var existingNotifications = notifications.html();
  var newNotificationHtml = `
          <li class="list-group-item list-group-item-action dropdown-notifications-item">
                    <div class="d-flex">
                      <div class="flex-shrink-0 me-3">
                        <div class="avatar">
                          <img src=" ${assetsPath}img/avatars/1.png" alt class="h-auto rounded-circle">
                        </div>
                      </div>
                      <div class="flex-grow-1">
                        <h6 class="mb-1">Nouvel Transaction ${event.transaction}</h6>
                        <p class="mb-0">${data.message}</p>
                        <small class="text-muted">1h ago</small>
                      </div>
                      <div class="flex-shrink-0 dropdown-notifications-actions">
                        <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                        <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="ti ti-x"></span></a>
                      </div>
                    </div>
                  </li>
        `;
  notifications.html(newNotificationHtml + existingNotifications);

  notificationsCount += 1;
  notificationsCountElem.attr('data-count', notificationsCount);
  notificationsCountElem.text(notificationsCount);

  notificationsWrapper.show();
});
*/
