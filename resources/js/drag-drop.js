import Sortable from 'sortablejs';

class TaskDragDrop {
  constructor() {
    this.container = null;
    this.sortable = null;
  }

  init() {
    this.container = document.querySelector('[data-tasks-container]');
    if (!this.container) return;

    this.sortable = Sortable.create(this.container, {
      animation: 150,
      handle: '.task-card',
      ghostClass: 'opacity-50',
      dragClass: 'shadow-2xl',
      chosenClass: 'ring-2 ring-indigo-500',
      onEnd: (evt) => {
        this.saveOrder();
      },
    });
  }

  async saveOrder() {
    const taskCards = this.container.querySelectorAll('[data-task-id]');
    const order = Array.from(taskCards).map((card, index) => ({
      id: parseInt(card.getAttribute('data-task-id'), 10),
      order: index + 1,
    }));

    try {
      const res = await fetch('/tasks/reorder', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
        },
        body: JSON.stringify({ order }),
      });

      const data = await res.json();
      if (data.success) {
        if (window.showToast) {
          window.showToast('Порядок задач сохранён', 'success');
        }
      } else {
        console.error('Failed to save order:', data.message);
      }
    } catch (e) {
      console.error('Error saving task order:', e);
    }
  }
}

window.addEventListener('DOMContentLoaded', () => {
  const dragDrop = new TaskDragDrop();
  dragDrop.init();
});
