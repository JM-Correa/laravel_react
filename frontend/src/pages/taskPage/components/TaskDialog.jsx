import { useState } from "react";
import { toast } from "sonner";
import { Loader2 } from "lucide-react";
import { Button } from "@/components/ui/button";
import {
  Dialog,
  DialogContent,
  DialogDescription,
  DialogFooter,
  DialogHeader,
  DialogTitle,
} from "@/components/ui/dialog";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Textarea } from "@/components/ui/textarea";
import { createTask, updateTask } from "@/api/taskApi";

// Sirve para crear (task = null) y para editar (task = la tarea)
export default function TaskDialog({ open, onOpenChange, task, onSaved }) {
  return (
    <Dialog open={open} onOpenChange={onOpenChange}>
      <DialogContent className="sm:max-w-md">
        {/* El formulario se monta cada vez que se abre el diálogo,
            así sus campos arrancan con los datos de la tarea (o vacíos) */}
        <TaskForm
          task={task}
          onSaved={onSaved}
          onClose={() => onOpenChange(false)}
        />
      </DialogContent>
    </Dialog>
  );
}

function TaskForm({ task, onSaved, onClose }) {
  const isEdit = Boolean(task);
  const [nombre, setNombre] = useState(task?.nombre ?? "");
  const [detalle, setDetalle] = useState(task?.detalle ?? "");
  const [saving, setSaving] = useState(false);

  const handleSubmit = async (e) => {
    e.preventDefault();

    if (!nombre.trim() || !detalle.trim()) {
      toast.error("Completa el nombre y el detalle");
      return;
    }

    try {
      setSaving(true);
      const data = { nombre: nombre.trim(), detalle: detalle.trim() };

      if (isEdit) await updateTask(task.idtask, data);
      else await createTask(data);

      toast.success(isEdit ? "Tarea actualizada" : "Tarea creada");
      onSaved();
      onClose();
    } catch (error) {
      toast.error(error.message);
    } finally {
      setSaving(false);
    }
  };

  return (
    <form onSubmit={handleSubmit} className="space-y-4">
      <DialogHeader>
        <DialogTitle>{isEdit ? "Editar tarea" : "Nueva tarea"}</DialogTitle>
        <DialogDescription>
          {isEdit ? "Modifica los datos de la tarea." : "Agrega una tarea a tu lista."}
        </DialogDescription>
      </DialogHeader>

      <div className="space-y-2">
        <Label htmlFor="nombre">Nombre</Label>
        <Input
          id="nombre"
          value={nombre}
          maxLength={45}
          placeholder="Ej. Estudiar Node"
          onChange={(e) => setNombre(e.target.value)}
        />
      </div>

      <div className="space-y-2">
        <Label htmlFor="detalle">Detalle</Label>
        <Textarea
          id="detalle"
          rows={4}
          value={detalle}
          placeholder="Describe la tarea"
          onChange={(e) => setDetalle(e.target.value)}
        />
      </div>

      <DialogFooter className="gap-2 sm:gap-0">
        <Button type="button" variant="outline" onClick={onClose}>
          Cancelar
        </Button>
        <Button type="submit" disabled={saving}>
          {saving && <Loader2 className="animate-spin" />}
          Guardar
        </Button>
      </DialogFooter>
    </form>
  );
}