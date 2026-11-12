import { useEffect, useState } from "react";
import { toast } from "sonner";
import { ClipboardList, Loader2, Pencil, Plus, Trash2 } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Card, CardContent } from "@/components/ui/card";
import { Checkbox } from "@/components/ui/checkbox";
import { cn } from "@/lib/utils";
import { deleteTask, getTasks, updateTask } from "@/api/taskApi";
import TaskDialog from "./components/TaskDialog";

export default function Task() {
  const [tasks, setTasks] = useState([]);
  const [loading, setLoading] = useState(true);
  const [dialogOpen, setDialogOpen] = useState(false);
  const [editingTask, setEditingTask] = useState(null); // null = crear

    // Recarga la lista (se usa después de crear, editar, eliminar o marcar)
  const loadTasks = async () => {
    try {
      setTasks(await getTasks());
    } catch (error) {
      toast.error(error.message);
    }
  };

  // Carga inicial
  useEffect(() => {
    getTasks()
      .then(setTasks)
      .catch((error) => toast.error(error.message))
      .finally(() => setLoading(false));
  }, []);

  const openCreate = () => {
    setEditingTask(null);
    setDialogOpen(true);
  };

  const openEdit = (task) => {
    setEditingTask(task);
    setDialogOpen(true);
  };

  // Marcar / desmarcar como completada (estatus 1 / 0)
  const handleToggle = async (task, checked) => {
    try {
      await updateTask(task.idtask, { estatus: checked ? 1 : 0 });
      await loadTasks();
    } catch (error) {
      toast.error(error.message);
    }
  };

  // Eliminar directo, sin diálogo de confirmación
  const handleDelete = async (task) => {
    try {
      await deleteTask(task.idtask);
      toast.success("Tarea eliminada");
      await loadTasks();
    } catch (error) {
      toast.error(error.message);
    }
  };

  const pendientes = tasks.filter((t) => !t.estatus).length;

  return (
    <main className="mx-auto w-full max-w-2xl p-4 sm:p-6">
      <header className="mb-6 flex items-center justify-between gap-3">
        <div>
          <h1 className="text-2xl font-semibold tracking-tight">Mis tareas</h1>
          <p className="text-sm text-muted-foreground">
            {pendientes} {pendientes === 1 ? "pendiente" : "pendientes"}
          </p>
        </div>
        <Button onClick={openCreate} aria-label="Nueva tarea">
          <Plus />
          <span className="hidden sm:inline">Nueva tarea</span>
        </Button>
      </header>

      {loading ? (
        <div className="flex justify-center py-16 text-muted-foreground">
          <Loader2 className="animate-spin" />
        </div>
      ) : tasks.length === 0 ? (
        <div className="flex flex-col items-center gap-2 py-16 text-center text-muted-foreground">
          <ClipboardList className="size-10" />
          <p>No hay tareas todavía</p>
        </div>
      ) : (
        <ul className="space-y-3">
          {tasks.map((task) => (
            <li key={task.idtask}>
              <Card className="py-0">
                <CardContent className="flex items-start gap-3 p-4">
                  <Checkbox
                    className="mt-1"
                    checked={Boolean(task.estatus)}
                    onCheckedChange={(checked) => handleToggle(task, checked === true)}
                    aria-label="Marcar como completada"
                  />

                  <div className="min-w-0 flex-1">
                    <p
                      className={cn(
                        "truncate font-medium",
                        task.estatus && "text-muted-foreground line-through"
                      )}
                    >
                      {task.nombre}
                    </p>
                    <p className="line-clamp-2 text-sm text-muted-foreground">
                      {task.detalle}
                    </p>
                  </div>

                  <div className="flex shrink-0 gap-1">
                    <Button
                      variant="ghost"
                      size="icon"
                      onClick={() => openEdit(task)}
                      aria-label="Editar tarea"
                    >
                      <Pencil />
                    </Button>
                    <Button
                      variant="ghost"
                      size="icon"
                      className="text-destructive hover:text-destructive"
                      onClick={() => handleDelete(task)}
                      aria-label="Eliminar tarea"
                    >
                      <Trash2 />
                    </Button>
                  </div>
                </CardContent>
              </Card>
            </li>
          ))}
        </ul>
      )}

      <TaskDialog
        open={dialogOpen}
        onOpenChange={setDialogOpen}
        task={editingTask}
        onSaved={loadTasks}
      />
    </main>
  );
}