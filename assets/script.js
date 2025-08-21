document.addEventListener('DOMContentLoaded', () => {
  const clearBtn = document.getElementById('clear-btn');
  const form = document.getElementById('calc-form');

  if (clearBtn && form) {
    clearBtn.addEventListener('click', () => {
      form.querySelectorAll('input[type="text"]').forEach(inp => inp.value = '');
      const select = form.querySelector('select[name="op"]');
      if (select) select.selectedIndex = 0;
    });
  }
});
