function addEvent(selector, event, callback) {
  var element = document.querySelectorAll(selector);
  for(var i = 0; i < element.length; i++) {
  	element[i]['on' + event] = callback;
  }
}

function each(array, callback) {
	for(var i = 0; i < array.length; i++) {
		callback(array[i]);
	}
}


function ajax_post(url, data, callback) {
	var ajax = new XMLHttpRequest();
	ajax.open("POST", url, true);

	ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

	ajax.onreadystatechange = function() {
		if(ajax.readyState == 4 && ajax.status == 200) {
			callback(ajax.responseText);
		}
	}
	ajax.send(data);
}



addEvent('a.addToShop', 'click', (event) => {
	const dataValue = document.getElementById('productId').value;
	const productName = document.getElementById('productName').value;
	orderProduct(dataValue, productName, 'add');
});

function orderProduct(productId, productName, action) {
	ajax_post('/addProduct', 'action=' + action + '&productName=' + productName + '&id=' + productId, responseText => {

		setTimeout(() => {
			ajax_post('/addProduct', 'action=timeout', responseText => {
				const amountInCart = document.getElementById('amountInCart');
					try{
						var json = JSON.parse(responseText);
						amountInCart.innerHTML = json.count;
						if(Boolean(json.content)) {
							parseContent(json.content);
						}
					}catch(e) {

					}
			});
		}, 100);
	});
}

function parseContent(contentArray) {
	document.querySelector('#content').innerHTML = contentArray;
}

function pagination(page) {
	ajax_post('/pagination', 'page=' + page, responseText => {
		document.getElementById('productContent').innerHTML = responseText;
	});
}

function changeAmount(product, amount) {
  ajax_post('/addProduct', 'action=updateAmount&amount=' + amount + '&productName=' + product, responseText => {return 0});
}

function changePrice() {
  const prices = document.querySelectorAll('input[name=price]');
  let price = 0;
  for(var i = 0; i < prices.length; i++) {
    var number = parseInt(prices[i].value);
    if(prices[i].nextSibling.firstElementChild.value > 10) {
      break;
    }
      price += prices[i].nextSibling.firstElementChild.value * prices[i].value;
  }

  document.getElementById('totalPrice').innerText = Math.round(price * 100) / 100;
}

changePrice();









//
