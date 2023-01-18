import { ref } from 'vue'
import Advancement from './types/Advancement'
import Book from './types/Book'
import User from '@/types/User'

const store = ref({
  advancements: JSON.parse(
    sessionStorage.getItem('advancements') || '[]'
  ) as Advancement[],
  books: JSON.parse(sessionStorage.getItem('books') || '[]') as Book[],
  user: {} as User,
})

export default store
