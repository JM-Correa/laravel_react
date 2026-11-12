const API_URL = "/api/tasks";

// Hace la petición y lanza un Error con el mensaje del backend si algo falla
async function request(url, options = {}) {
  const res = await fetch(url, {
    headers: { "Content-Type": "application/json" },
    ...options,
  });

  if (res.status === 204) return null; // DELETE no devuelve body

  const data = await res.json().catch(() => null);
  if (!res.ok) throw new Error(data?.error || "Error en la petición");
  return data;
}

export const getTasks = () => request(API_URL);

export const createTask = (task) =>
  request(API_URL, { method: "POST", body: JSON.stringify(task) });

export const updateTask = (id, changes) =>
  request(`${API_URL}/${id}`, { method: "PUT", body: JSON.stringify(changes) });

export const deleteTask = (id) => request(`${API_URL}/${id}`, { method: "DELETE" });