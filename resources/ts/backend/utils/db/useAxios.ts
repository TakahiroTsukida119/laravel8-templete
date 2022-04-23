import Axios from 'axios';
import { ref } from 'vue';

/**
 * axios
 */
export default function () {
  const token = ref<string | null>(null);
  token.value = document.head
    .querySelector('meta[name="csrf-token"]')
    ?.getAttribute('content')!;
  const axios = Axios.create({
    withCredentials: true,
    headers: {
      'Content-Type': 'application/json',
      'X-Requested-With': 'XMLHttpRequest',
      'X-CSRF-TOKEN': token.value,
    },
    responseType: 'json',
  })

  return { axios }
}
