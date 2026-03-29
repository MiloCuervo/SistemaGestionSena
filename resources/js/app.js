import Alpine from 'alpinejs'
import { Livewire, Alpine as AlpineWire } from '../../vendor/livewire/livewire/dist/livewire.esm'

// Registrar plugin de Livewire en Alpine
Alpine.plugin(AlpineWire)

// Iniciar Livewire
Livewire.start()

// Iniciar Alpine - Flux manejará componentes dinámicos
Alpine.start()
