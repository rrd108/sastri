interface Advancement {
  id: number
  user_id: number
  book_id: number
  date: string
  pages: number
  book: {
    id: number
    title: string
    pages: number
  }
}

export default Advancement
