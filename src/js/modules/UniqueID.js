let IDString = 'form-field-'
let UUID = 0

export default function UniqueID () {
  const getID = () => {
    UUID++
    return IDString + UUID
  }

  return {
    getID
  }
}