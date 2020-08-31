

	var is_support_noti = true;

	

	if ("mozNotification" in navigator) {

		window.Notification = {

			"permission": "granted"

		};

	}



	var Handler = {

		checkPermission: function () {

			if ("mozNotification" in navigator) {

				is_support_noti = true;

			} else {

				Notification.requestPermission(function (permission) {

					if (permission === "granted") {

						is_support_noti = true;

					}

				});

			}

		},

		displayNotification: function (title, message, icon, delay, onclick) {

			var instance;

			

			if (title.length > 0) {

				var attributes = {};

				

				delay = Math.max(0, Math.min(60, delay));

				

				if (message.length > 0) {

					attributes.body = message.substr(0, 250);

				}

				

				if (icon.length > 0) {

					attributes.icon = icon;

				}

				

				if ("mozNotification" in navigator) {

					if (delay > 0) {

						window.setTimeout(function () {

							instance = navigator.mozNotification.createNotification(title.substr(0, 100), attributes.body || '', attributes.icon || null);

							

							if (onclick !== undefined) {

								instance.onclick = onclick;

							}



							instance.show();

						}, delay * 1000);

					} else {

						instance = navigator.mozNotification.createNotification(title.substr(0, 100), attributes.body || '', attributes.icon || null);

						

						if (onclick !== undefined) {

							instance.onclick = onclick;

						}



						instance.show();

					}

				} else {

					if (delay > 0) {

						window.setTimeout(function () {

							instance = new Notification(title.substr(0, 100), attributes);

							

							if (onclick !== undefined) {

								instance.onclick = onclick;

							}

						}, delay * 1000);

					} else {

						instance = new Notification(title.substr(0, 100), attributes);

						

						if (onclick !== undefined) {

							instance.onclick = onclick;

						}

					}

				}

			}

		}

	};





	function alertBox(content) {

        if(is_support_noti==false) return false;

        if (Notification.permission === "granted") {

			Handler.displayNotification('Gia Đình Việt Nam', content, '/asset/images/medium-logo.png', 0);

		} else {

			is_support_noti = false;

		}

	}

    

    if ((!window.Notification && !navigator.mozNotification) || !window.FileReader || !window.history.pushState) is_support_noti = false;

    else Handler.checkPermission();

