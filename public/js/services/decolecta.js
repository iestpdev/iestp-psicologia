import { showToast } from '../shared/toasts/notyf.js';

const BASE_URL = document.querySelector('meta[name="base-url"]').content;

/**
 * Consulta la API de Decolecta con el DNI ingresado y llena los campos
 * de nombres y apellidos automáticamente.
 */
async function loadInfoReniec(inputDNI) {
  // Detectar el contexto (modal o formulario normal)
  const modalBody = inputDNI.closest('.modal-body');
  const formContainer = inputDNI.closest('form');
  const context = modalBody || formContainer || document;

  // Buscar los campos en el mismo contexto
  const nombres = context.querySelector('[id^="nombres"], [name="nombres"]');
  const apellidos = context.querySelector('[id^="apellidos"], [name="apellidos"]');
  const btnSubmit = context.querySelector('button[type="submit"]');

  const dni = inputDNI.value.trim();

  // Validación rápida
  if (dni.length !== 8) {
    if (nombres) nombres.value = "";
    if (apellidos) apellidos.value = "";
    btnSubmit?.classList.remove("disabled");
    return;
  }

  try {
    btnSubmit?.classList.add("disabled");

    const res = await fetch(`${BASE_URL}api/decolecta/dni/${dni}`);
    const data = await res.json().catch(() => null);

    if (res.status === 200 && data?.first_name) {
      if (nombres) nombres.value = data.first_name;
      if (apellidos) apellidos.value = `${data.first_last_name ?? ""} ${data.second_last_name ?? ""}`.trim();
      showToast('success', 'Se encontraron resultados del DNI');
    } 
    else if (res.status === 404) {
      if (nombres) nombres.value = "";
      if (apellidos) apellidos.value = "";
      showToast('warning', 'DNI no encontrado en RENIEC');
    } 
    else if (res.status === 502) {
      if (nombres) nombres.value = "";
      if (apellidos) apellidos.value = "";
      showToast('error', 'Error al comunicarse con Decolecta');
    } 
    else {
      if (nombres) nombres.value = "";
      if (apellidos) apellidos.value = "";
      showToast('error', 'Error inesperado al consultar el DNI');
    }

  } catch (error) {
    console.error("Error al consultar API Decolecta:", error);
    showToast('error', 'Error interno al consultar API Decolecta');
    if (nombres) nombres.value = "";
    if (apellidos) apellidos.value = "";
  } finally {
    btnSubmit?.classList.remove("disabled");
  }
}

/**
 * Añade el listener de forma dinámica para todos los inputs relacionados con DNI.
 * Soporta formularios normales y modales.
 */
document.addEventListener("DOMContentLoaded", () => {
  const attachListeners = (root = document) => {
    root.querySelectorAll('input[id^="dni"], input[name="dni"]').forEach(inputDNI => {
      if (!inputDNI.dataset.listenerAdded) {
        inputDNI.addEventListener("input", () => loadInfoReniec(inputDNI));
        inputDNI.dataset.listenerAdded = true;
      }
    });
  };

  // Ejecutar al cargar la página
  attachListeners();

  // Reaplicar listeners cuando se abra un modal
  document.addEventListener('shown.bs.modal', (event) => {
    attachListeners(event.target);
  });
});
