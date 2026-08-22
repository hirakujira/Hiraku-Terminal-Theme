(function () {
  var config = window.hirakuTerminalOkxSort;
  var list = document.querySelector('[data-okx-sort-list]');
  var saveButton = document.querySelector('[data-okx-sort-save]');
  var spinner = document.querySelector('[data-okx-sort-spinner]');
  var status = document.querySelector('[data-okx-sort-status]');

  if (!config || !list || !saveButton || !spinner || !status) {
    return;
  }

  var draggedItem = null;

  function moveItem(item, direction) {
    var sibling = direction === 'up' ? item.previousElementSibling : item.nextElementSibling;

    if (!sibling) {
      return;
    }

    if (direction === 'up') {
      list.insertBefore(item, sibling);
    } else {
      list.insertBefore(sibling, item);
    }

    item.focus();
  }

  list.addEventListener('dragstart', function (event) {
    var item = event.target.closest('[data-post-id]');

    if (!item) {
      return;
    }

    draggedItem = item;
    item.classList.add('is-dragging');
    event.dataTransfer.effectAllowed = 'move';
    event.dataTransfer.setData('text/plain', item.dataset.postId);
  });

  list.addEventListener('dragover', function (event) {
    var target = event.target.closest('[data-post-id]');

    if (!draggedItem || !target || target === draggedItem) {
      return;
    }

    event.preventDefault();

    var shouldInsertBefore = event.clientY < target.getBoundingClientRect().top + (target.offsetHeight / 2);
    list.insertBefore(draggedItem, shouldInsertBefore ? target : target.nextElementSibling);
  });

  list.addEventListener('dragend', function () {
    if (draggedItem) {
      draggedItem.classList.remove('is-dragging');
      draggedItem = null;
    }
  });

  list.addEventListener('keydown', function (event) {
    var item = event.target.closest('[data-post-id]');

    if (!item || event.target.closest('[data-okx-sort-type]')) {
      return;
    }

    if (event.key === 'ArrowUp') {
      event.preventDefault();
      moveItem(item, 'up');
    }

    if (event.key === 'ArrowDown') {
      event.preventDefault();
      moveItem(item, 'down');
    }
  });

  list.addEventListener('click', function (event) {
    var button = event.target.closest('[data-okx-sort-move]');

    if (!button) {
      return;
    }

    var item = button.closest('[data-post-id]');
    moveItem(item, button.dataset.okxSortMove);
  });

  saveButton.addEventListener('click', function () {
    var postIds = Array.prototype.map.call(list.querySelectorAll('[data-post-id]'), function (item) {
      return item.dataset.postId;
    });
    var body = new URLSearchParams();

    body.append('action', 'hiraku_terminal_save_okx_order');
    body.append('nonce', config.nonce);
    postIds.forEach(function (postId) {
      body.append('post_ids[]', postId);
    });
    Array.prototype.forEach.call(list.querySelectorAll('[data-post-id]'), function (item) {
      var typeSelect = item.querySelector('[data-okx-sort-type]');

      body.append('post_types[' + item.dataset.postId + ']', typeSelect ? typeSelect.value : '');
    });

    saveButton.disabled = true;
    spinner.classList.add('is-active');
    status.textContent = config.savingText;

    fetch(config.ajaxUrl, {
      method: 'POST',
      credentials: 'same-origin',
      headers: {
        'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
      },
      body: body.toString()
    })
      .then(function (response) {
        return response.json();
      })
      .then(function (response) {
        status.textContent = response && response.data && response.data.message ? response.data.message : config.unexpectedError;
      })
      .catch(function () {
        status.textContent = config.unexpectedError;
      })
      .finally(function () {
        saveButton.disabled = false;
        spinner.classList.remove('is-active');
      });
  });
})();
