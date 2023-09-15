<tr>
  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{ $forest->forest_name }}</td>
  <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-gray-200">{{ $forest->owner->name }}</td>
  <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-gray-200">人検討中</td>
  <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
    <a class="text-blue-500 hover:text-blue-700" href="{{ route('forest.detail', ['id' => $forest->id]) }}">詳細</a>
  </td>
   <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <a class="text-blue-500 hover:text-blue-700" href="#">参加</a>
  </td>
   <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
            <a class="text-blue-500 hover:text-blue-700" href="#">編集</a>
  </td>
</tr