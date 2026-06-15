(function () {
  document.querySelectorAll('.search-form').forEach(function (form) {
    form.addEventListener('submit', function (event) {
      var input = form.querySelector('.search-field');

      if (!input || input.value.trim()) {
        return;
      }

      event.preventDefault();
      input.focus();
    });
  });

  function activateCategory(browser, target) {
    if (!target) {
      return;
    }

    browser.querySelectorAll('.category-parent').forEach(function (button) {
      var active = button.dataset.categoryTarget === target;
      button.classList.toggle('is-active', active);
      button.setAttribute('aria-expanded', active ? 'true' : 'false');
    });

    browser.querySelectorAll('.category-detail').forEach(function (panel) {
      panel.classList.toggle('is-active', panel.dataset.categoryDetail === target);
    });
  }

  function fitMegaPanel(menu) {
    var panel = menu.querySelector('.mega-panel');
    if (!panel) {
      return;
    }

    panel.style.setProperty('--mega-panel-shift', '0px');

    var margin = 28;
    var rect = panel.getBoundingClientRect();
    var shift = 0;

    if (rect.right > window.innerWidth - margin) {
      shift -= rect.right - (window.innerWidth - margin);
    }

    if (rect.left + shift < margin) {
      shift += margin - (rect.left + shift);
    }

    panel.style.setProperty('--mega-panel-shift', shift + 'px');
  }

  document.querySelectorAll('.category-browser').forEach(function (browser) {
    var first = browser.querySelector('.category-parent');
    if (first && !browser.classList.contains('is-mobile')) {
      activateCategory(browser, first.dataset.categoryTarget);
    }

    browser.addEventListener('mouseover', function (event) {
      var button = event.target.closest('.category-parent');
      if (!button || !browser.contains(button) || browser.classList.contains('is-mobile')) {
        return;
      }
      activateCategory(browser, button.dataset.categoryTarget);
    });

    browser.addEventListener('focusin', function (event) {
      var button = event.target.closest('.category-parent');
      if (!button || !browser.contains(button)) {
        return;
      }
      activateCategory(browser, button.dataset.categoryTarget);
    });

    browser.addEventListener('click', function (event) {
      var parent = event.target.closest('.category-parent');
      if (parent && browser.contains(parent)) {
        activateCategory(browser, parent.dataset.categoryTarget);

        if (browser.classList.contains('is-mobile')) {
          event.preventDefault();
          browser.classList.add('is-drilling');
          browser.closest('.mobile-panel')?.classList.add('is-category-drilling');
        }

        return;
      }

      var back = event.target.closest('.category-back');
      if (back && browser.contains(back)) {
        event.preventDefault();
        browser.classList.remove('is-drilling');
        browser.closest('.mobile-panel')?.classList.remove('is-category-drilling');
      }
    });
  });

  document.addEventListener('click', function (event) {
    document.querySelectorAll('.category-menu[open]').forEach(function (menu) {
      if (!menu.contains(event.target)) {
        menu.removeAttribute('open');
      }
    });
  });

  document.querySelectorAll('.category-menu').forEach(function (menu) {
    menu.addEventListener('toggle', function () {
      if (menu.open) {
        requestAnimationFrame(function () {
          fitMegaPanel(menu);
        });
      }
    });
  });

  document.querySelectorAll('.mobile-search, .mobile-menu').forEach(function (panel) {
    panel.addEventListener('toggle', function () {
      if (!panel.open) {
        var mobilePanel = panel.querySelector('.mobile-panel');
        var mobileBrowser = panel.querySelector('.category-browser.is-mobile');

        if (mobilePanel) {
          mobilePanel.classList.remove('is-category-drilling');
        }
        if (mobileBrowser) {
          mobileBrowser.classList.remove('is-drilling');
        }

        return;
      }

      document.querySelectorAll('.mobile-search, .mobile-menu').forEach(function (otherPanel) {
        if (otherPanel !== panel) {
          otherPanel.removeAttribute('open');
        }
      });

      if (panel.classList.contains('mobile-search')) {
        requestAnimationFrame(function () {
          var input = panel.querySelector('.search-field');
          if (input) {
            input.focus();
          }
        });
      }
    });
  });

  document.addEventListener('click', function (event) {
    document.querySelectorAll('.mobile-search[open], .mobile-menu[open]').forEach(function (panel) {
      if (!panel.contains(event.target)) {
        panel.removeAttribute('open');
      }
    });
  });

  window.addEventListener('resize', function () {
    document.querySelectorAll('.category-menu[open]').forEach(fitMegaPanel);
  });
})();
