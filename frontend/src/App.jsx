import { BrowserRouter, Route, Routes, Navigate } from 'react-router-dom'
import { Toaster } from './components/ui/sonner'

import Task from './pages/taskpage/Task'

function App() {

  return (
    <BrowserRouter>
      <Toaster richColors position="top-center" />

      <Routes>
        {/* --- Redirección automática --- */}
        <Route path='/' element={<Navigate to="/tareas" replace />} />

        {/* --- Ruta --- */}
        <Route path='/tareas' element={<Task />} />
      </Routes>
    </BrowserRouter>
  )
}

export default App